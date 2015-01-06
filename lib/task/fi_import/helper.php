<?php
function nowAlt($type = null){
	if(is_null($type) || $type == 0){
		$return = '"'.date('Y-m-d H:i:s', time()).'"';
	}else{
		$return = "'".date('Y-m-d H:i:s', time())."'";
	}
	//$return = addslashes($return);
	return $return;
}
$connections = array(
  'staging' => array(
    'DSN' => 'mysql:host=dev.ned.local;dbname=getlokal;charset=utf8',
    'DSN_USER' => 'getlokal',
    'DSN_PASSWORD' => '3Swygyigh'
  ),
  'dev' => array(
    'DSN' => 'mysql:host=dev.ned.local;dbname=getlokal_dev;charset=utf8',
    'DSN_USER' => 'getlokal',
    'DSN_PASSWORD' => '3Swygyigh'
  )
);

if (!array_key_exists($connection, $connections)) {
  echo 'Invalid connection name, available: ' . implode('|', array_keys($connections)) . "\n";
  exit(2);
}
extract($connections[$connection]);
global $dbh;
$dbh = new PDO($DSN, $DSN_USER, $DSN_PASSWORD);

$culture_country = array(
  'bg' => array(1, 'Bulgaria'),
  'ro' => array(2, 'Romania'),
  'mk' => array(3, 'Macedonia'),
  'sr' => array(4, 'Serbia')
);

$country_id = 78;

// ensure the table exists
function create_table()
{
  global $dbh;
  $sql = '
  CREATE  TABLE IF NOT EXISTS `company_import` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `title` VARCHAR(255) NULL ,
    `title_en` VARCHAR(255) NULL ,
    `classification_id` INT NULL ,
    `city_id` INT NULL ,
    `phone` VARCHAR(80) NULL ,
    `email` VARCHAR(255) NULL ,
    `full_address` VARCHAR(255) NULL ,
    `location_type` INT NULL ,
    `street_type` INT NULL ,
    `street_name` VARCHAR(255) NULL ,
    `street_number` VARCHAR(45) NULL ,
    `building_number` VARCHAR(45) NULL ,
    `floor` VARCHAR(45) NULL ,
    `appartment` VARCHAR(45) NULL ,
    `neighborhood` VARCHAR(255) NULL ,
    `postal_code` VARCHAR(45) NULL ,
    `website_url` TEXT NULL ,
    `googleplus_url` TEXT NULL ,
    `foursquare_url` TEXT NULL ,
    `twitter_url` TEXT NULL ,
    `facebook_url` TEXT NULL ,
    `company_type` INT NULL ,
    `culture` VARCHAR(10) NULL ,
    `country` VARCHAR(45) NULL ,
    `lat` DOUBLE(18,10) NULL ,
    `lng` DOUBLE(18, 10) NULL ,
    `sublocation` VARCHAR(255) NULL ,
    PRIMARY KEY (`id`) );
  ';
  $dbh->exec($sql);
}

function create_extra_table()
{
  global $dbh;
  $sql = '
  CREATE TABLE IF NOT EXISTS company_extra(
    id BIGINT AUTO_INCREMENT,
    company_id BIGINT,
    establishment_date VARCHAR(255),
    registration_date VARCHAR(255),
    company_form VARCHAR(255),
    business_type VARCHAR(255),
    nace_code VARCHAR(255),
    personal_abount VARCHAR(255),
    personal_year VARCHAR(255),
    turnover VARCHAR(255),
    turnover_year VARCHAR(255),
    tax_reg VARCHAR(255),
    financial_risk VARCHAR(255),
    source VARCHAR(255),
    INDEX company_id_idx (company_id),
    PRIMARY KEY(id)
  ) ENGINE = INNODB;';
  $dbh->exec($sql);
}

function get_row()
{
  global $file, $fields, $city_id, $culture, $culture_country, $country_id;
  $filedCount = sizeof($fields);
  static $fh = null;
  if (is_null($fh))
  {
    if (!isset($file))
    {
      return false;
    }
    $fh = fopen($file, 'r');
    // discard first line as being the headers
    fgetcsv($fh);
  }

  if($row = fgetcsv($fh))
  {
    $row = array_combine( $fields, array_slice(normalize_row($row), 0, $filedCount) );
    $row['country_id'] = $country_id; // finland
    $row['city_id'] = _get_city_by_name($row['city'], $row['county']);
    unset($row['city'], $row['county']);

    return $row;
  }
  // no more rows, close the file
  fclose($fh);
}

// ensure number of elements
function normalize_row($row)
{
  global $fields;
  while (count($fields) > count($row))
  {
    $row[] = '';
  }

  return $row;
}

function geocode(&$row)
{
  if (empty($row['full_address']))
  {
    $address = sprintf('%s %s %s %s %s %s',
      $row['postal_code'],
      $row['street_name'],
      $row['street_number'],
      $row['building_number'],
      $row['floor'],
      $row['appartment']);
  }
  else
  {
    $address = $row['full_address'];
  }

  $address = urlencode($address . ', ' . $row['city'] . ', ' . $row['country']);
  $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=". $row['culture'];
  $geocode = json_decode(file_get_contents($url), true);
  if ($geocode['status'] != 'OK')
  {
    return;
  }
  // google types mapped to db fields
  $_types = array(
    'street_number' => array('street_number'),
    'street_name' => array('street_address', 'route'),
    'neighborhood' => array('neighborhood'),
    // 'building_no' => ,
    // 'floor' => ,
    'appartment' => array('room'),
    'postal_code' => array('postal_code'),
    'sublocation' => array(
      'intersection', 'sublocality', 'sublocality_level_1', 'sublocality_level_2',
      'sublocality_level_3', 'sublocality_level_4', 'sublocality_level_5'
    ),
  );

  $results = $geocode['results'][0];
  $components = $results['address_components'];

  $row = array_merge($row, array(
    'lat' => $results['geometry']['location']['lat'],
    'lng' => $results['geometry']['location']['lng'],
    'sublocation' => '',
    'accuracy' => 0
  ));

  if (empty($row['full_address']))
  {$row['full_address'] = $results['formatted_address'];
  }

  foreach ($components as $c) {
    foreach ($_types as $field => $types) {
      if (array_intersect($types, $c['types'])) {
        $row['accuracy']++;
        $row[$field] = $c['long_name'];
      }
    }
  }
}

function get_sector($classification_id) {
  global $dbh;
  $sql = "SELECT sector_id FROM classification WHERE id = %d LIMIT 1";
  $sector_id = (int) $dbh->query(sprintf($sql, $classification_id))->fetchColumn(0);
  return $sector_id;
}

function unique_slug($text) {
  global $dbh;
  $slug = $text;
  $i=0;
  $sql = "SELECT COUNT(*) FROM company WHERE slug = '%s'";
  if ($result = $dbh->query(sprintf($sql, $text))) {
    while($result->fetchColumn(0) > 0){
    	$i++;
    	$text = $slug.$i;
    	$result = $dbh->query(sprintf($sql, $text));
    }  	
  }
  return $text;
}


function insert_row($row)
{
  global $dbh, $country_id;
  list($phone, $phone1, $phone2) = explode('/', $row['phone']) + array(null, null, null);
  if($row['title_en'] == '' || is_null($row['title_en'])){
  	$row['title_en'] = getTitleEn($row['title']);
  }
  $company_data = array(
    'external_id' => $row['id'],
  	'title' => $row['title'],
    'title_en' => $row['title_en'],
    'email' => $row['email'],
    'phone' => $phone,
    'phone1' => $phone1,
    'phone2' => $phone2,
    'website_url' => $row['website_url'],
    'city_id' => $row['city_id'],
    'sector_id' => get_sector($row['classification_id']),
    'classification_id' => $row['classification_id'],
    'company_type' => $row['company_type'],
    'is_validated' => 'validated',
    'status' => 0,
    'facebook_url' => $row['facebook_url'],
    'foursquare_url' => $row['foursquare_url'],
    'twitter_url' => $row['twitter_url'],
    'registration_no' => $row['registration_no'],
    'country_id' => $country_id,
    'slug' => unique_slug(slugify($row['title_en'])),
    'facebook_id' => $row['facebook_id']
  );
  $company_id = insert($company_data, 'company');

  //////////////////////////////////////////////////////////
  $company_translation_data = array('id' => $company_id, 'title' => $row['title'], 'lang' => 'fi');
  insert($company_translation_data, 'company_translation', false);
  
  $company_translation_data = array('id' => $company_id, 'title' => $row['title_en'], 'lang' => 'en');
  insert($company_translation_data, 'company_translation', false);
  
  $company_translation_data = array('id' => $company_id, 'title' => TransliterateFi::toRu($row['title']), 'lang' => 'ru');
  insert($company_translation_data, 'company_translation', false);
  //////////////////////////////////////////////////////////
  
  
  $page_data = array(
    'foreign_id' => $company_id,
    'is_public' => 1,
    'type' => 2
  );
  insert($page_data, 'page');

  $location_data = array(
    'accuracy' => $row['accuracy'],
    'company_id' => $company_id,
    'is_active' => 1,
    'location_type' => $row['location_type'],
    'street_type_id' => $row['street_type'],
    'street_number' => $row['street_number'],
    'street' => $row['street'],
    'neighbourhood' => $row['neighbourhood'],
    'building_no' => $row['building_no'],
    'entrance' => $row['entrance'],
    'floor' => $row['floor'],
    'appartment' => $row['appartment'],
    'postcode' => $row['postcode'],
    'latitude' => $row['latitude'],
    'longitude' => $row['longitude'],
    'full_address' => $row['full_address'],
    'address_info' => $row['address_info'],
  );
  $location_id = insert($location_data, 'company_location');
  update_company_location($company_id, $location_id);

  // extra data
  $company_extra_data = array(
    'company_id' => $company_id,
    'establishment_date' => $row['establishment_date'],
    'registration_date' => $row['registration_date'],
    'company_form' => $row['company_form'],
    'business_type' => $row['business_type'],
    'nace_code' => $row['nace_code'],
    'personal_abount' => $row['personal_abount'],
    'personal_year' => $row['personal_year'],
    'turnover' => $row['turnover'],
    'turnover_year' => $row['turnover_year'],
    'tax_reg' => $row['tax_reg'],
    'financial_risk' => $row['financial_risk'],
    'source' => $row['source'],
  );
  insert($company_extra_data, 'company_extra', false);
  echo "Imported company with id: " . $company_id . "\n";
}

function update_company_location($company_id, $location_id) {
  global $dbh;
  $sql = "UPDATE company SET location_id = ? WHERE id = ?";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array($location_id, $company_id)) or die(print_r($stmt->errorInfo(), true));
}

function insert($data, $table, $date = true) {
  global $dbh;
  $fields = implode(', ', array_keys($data));
  $values = str_repeat('?,', count($data));
  if ($date) {
    $fields .= ', created_at, updated_at';
    $values .= ' '.nowAlt().', '.nowAlt().'';
  } else {
    $values = substr($values, 0, strlen($values) - 1);
  }

  $sql = "INSERT INTO {$table}({$fields}) VALUES({$values})";
  $st = $dbh->prepare($sql);
  $st->execute(array_values($data)) or die(print_r($st->errorInfo(), true));
  return $dbh->lastInsertId();
}

function get_city_name($city_id)
{
  static $_cache = array();
  if (!isset($_cache[$city_id]))
  {
    $_cache[$city_id] = _get_city_name($city_id);
  }
  return $_cache[$city_id];

}

$countyMap = array();
$cityMap = array();

function _get_city_by_name($city, $county)
{
  global $dbh, $country_id, $countyMap, $cityMap;
  if (array_key_exists($county, $countyMap)) {
    $county_id = $countyMap[$county];
  } else {
    $sql = "SELECT id FROM county WHERE (name = '%s' OR municipality = '%s') AND country_id = %d LIMIT 1";
    if (!$county_id = $dbh->query(sprintf($sql, $county, $county, $country_id))->fetchColumn(0)) {
      $data = array(
        'name' => $county,
        'country_id' => $country_id
      );
      $county_id = insert($data, 'county', false);
    }
    $countyMap[$county] = $county_id;
  }

  $city_id = null;
  if (array_key_exists($city, $cityMap)) {
    return $cityMap[$city];
  } else {
    $sql = "SELECT id FROM city WHERE (name = '%s' OR name_en = '%s') AND county_id = %d";
    $city_en = slugify($city);
    if (!$city_id = $dbh->query(sprintf($sql, $city, $city_en, $county_id))->fetchColumn(0)) {
      $data = array(
        'name' => $city,
        'name_en' => $city_en,
        'slug' => $city_en,
        'county_id' => $county_id
      );
      $city_id = insert($data, 'city', false);
    }
    $cityMap[$city] = $city_id;
  }

  return $city_id;
}

function slugify($str, $options = array())
{
  // Make sure string is in UTF-8 and strip invalid UTF-8 characters
  $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

  $defaults = array(
    'delimiter' => '-',
    'limit' => null,
    'lowercase' => true,
    'replacements' => array(),
    'transliterate' => true,
  );

  // Merge options
  $options = array_merge($defaults, $options);

  $char_map = array(
    // Latin
    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
    'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
    'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
    'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
    'ß' => 'ss',
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
    'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
    'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
    'ÿ' => 'y',

    // Latin symbols
    '©' => '(c)',

    // Greek
    'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
    'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
    'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
    'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
    'Ϋ' => 'Y',
    'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
    'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
    'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
    'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
    'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

    // Turkish
    'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
    'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

    // Russian
    'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
    'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
    'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
    'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
    'Я' => 'Ya',
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
    'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
    'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
    'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
    'я' => 'ya',

    // Ukrainian
    'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
    'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

    // Czech
    'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
    'Ž' => 'Z',
    'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
    'ž' => 'z',

    // Polish
    'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
    'Ż' => 'Z',
    'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
    'ż' => 'z',

    // Latvian
    'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
    'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
    'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
    'š' => 's', 'ū' => 'u', 'ž' => 'z'
  );

  // Make custom replacements
  $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

  // Transliterate characters to ASCII
  if ($options['transliterate']) {
    $str = str_replace(array_keys($char_map), $char_map, $str);
  }

  // Replace non-alphanumeric characters with our delimiter
  $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

  // Remove duplicate delimiters
  $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

  // Truncate slug to max. characters
  $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

  // Remove delimiter from ends
  $str = trim($str, $options['delimiter']);

  return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

function update_cls_no_places() {
    global $dbh;
    $sql = "
        UPDATE classification_translation CT
        SET CT.number_of_places = (SELECT COUNT(*) FROM company C WHERE C.classification_id = CT.id)";
    $dbh->query($sql);
}


function n_geocode_city($city) {
    $url = 'http://nominatim.openstreetmap.org/search?q=%s&format=json';
    $query = "{$city['city']} {$city['county']} Finland\n";
    print_r($query);
    $url = sprintf($url, urlencode($query));

    $response = json_decode(file_get_contents($url));
    print_r($response);
    if ($response && !empty($response)) {
        $result = array(
            ':id' => $city['id'],
            ':lat' => $response[0]->lat,
            ':lng' => $response[0]->lon,
        );
        return $result;
    }
    return false;
}

function getTitleEn($title){
	return TransliterateFi::toLatin($title);
}
