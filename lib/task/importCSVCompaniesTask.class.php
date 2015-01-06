<?php

class importCSVCompaniesTask extends sfBaseTask
{

  protected
    $city = null,
    $duplicates = array(),
    $rowCount = 0;

  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('file', sfCommandArgument::REQUIRED, 'CSV File to import.'),
      new sfCommandArgument('city', sfCommandArgument::REQUIRED, 'City ID to import in.'),
      new sfCommandArgument('application', sfCommandArgument::OPTIONAL, 'Application', 'frontend')
    ));

    $this->addOptions(array(
      new sfCommandOption('output', 'o', sfCommandOption::PARAMETER_OPTIONAL, 'The csv file to output duplicates too.', 'duplicates.csv')
    ));

    $this->namespace = 'import';
    $this->name = 'csv-companies';
    $this->briefDescription = 'Import companies from CSV file.';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->getCon();
    $this->createContext();
    $this->city = $this->getCity($arguments['city']);

    // open the file
    $this->getRow($arguments['file'], true);

    gc_enable();
    while ($row = $this->getRow())
    {
      $this->rowCount++;
      $this->processRow($row);
      gc_collect_cycles();
    }
    gc_disable();

    if (!empty($this->duplicates)) {
      $this->saveDuplicates($options['output']);
    } else {
      echo "No duplicates.\n";
    }
  }

  protected function saveDuplicates($filename)
  {
    $fh = fopen($filename, 'w+');
    foreach ($this->duplicates as $fields)
    {
      fputcsv($fh, $fields);
    }
    fclose($fh);
  }

  protected function processRow($row)
  {
    list($company, $duplicated) = $this->getCompany($row);

    if ($duplicated)
    {
      echo 'Duplicated:' . $company->getTitle() . "\n";
      $this->duplicates[] = array(
        $company->getId(),
        $company->getTitle(),
        $this->rowCount
      );
    }
    else
    {
      $this->createCompanyLocation($company, $row[1]);
      echo 'Imported: ' . $company->getId() . ' : ' . $company->getTitle() . "\n";
    }

    if ($company)
    {
      $company->free();
      unset($company);
    }
  }

  protected function getCompany($row)
  {
    $phone = str_replace(' ', '', trim($row[3]));
    $phoneParams = array($phone, $phone, $phone);
    $query = Doctrine::getTable('Company')->createQuery('c')
      ->where('c.phone = ? OR c.phone1 = ? OR c.phone2 = ?', $phoneParams)
      ->andWhere('c.city_id = ?', $this->city->getId());

    if ($query->count() > 0)
    {
      // mark duplicated
      return array($query->fetchOne(), true);
    }

    // create company
    $company = new Company();

    $company->setTitle($row[0]);
    $company->setPhone($phone);
    $company->setEmail($row[4]);
    $company->setClassificationId($row[5]);
    $company->setSectorId($row[6]);
    $company->setCityId($this->city->getId());
    $company->setStatus('approved');

    $company->save();

    return array($company, false);
  }

  protected function createCompanyLocation($company, $address)
  {
    $address = urlencode($address . ' ' . $this->city->getName() . ' ' . $this->city->getCountry());
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=". $this->lang;

    $geocode = json_decode(file_get_contents($url), true);
    if ($geocode['status'] != 'OK')
    {
      return;
    }
    // google types mapped to db fields
    $_types = array(
      'street_number' => array('street_number'),
      'street' => array('street_address', 'route'),
      'neighbourhood' => array('neighborhood'),
      // 'building_no' => ,
      // 'floor' => ,
      'appartment' => array('room'),
      'postcode' => array('postal_code'),
      'sublocation' => array(
        'intersection', 'sublocality', 'sublocality_level_1', 'sublocality_level_2',
        'sublocality_level_3', 'sublocality_level_4', 'sublocality_level_5'
      ),
    );

    $results = $geocode['results'][0];
    $components = $results['address_components'];

    $data = array(
      'street_type_id' => 6,
      'latitude' => $results['geometry']['location']['lat'],
      'longitude' => $results['geometry']['location']['lng'],
      'full_address' => $results['formatted_address'],
      'accuracy' => 0
    );

    foreach ($components as $c)
    {
      foreach ($_types as $field => $types)
      {
        if (array_intersect($types, $c['types']))
        {
          $data['accuracy']++;
          $data[$field] = $c['long_name'];
        }
      }
    }

    $company_location = new CompanyLocation();
    $company_location->setCompanyId($company->getId());

    foreach ($data as $field => $value)
    {
      $company_location->set($field, $value);
    }

    $company_location->save();
    $company_location->free();
    unset($company_location);
  }

  protected static function getRow($file = null, $set = false)
  {
    static $fh = null;

    if (is_null($fh))
    {
      if (is_null($file))
      {
        throw new Exception('You must specify a file.');
      }

      $fh = fopen($file, 'r');
    }
    if ($set)
    {
      return null;
    }

    if ($row = fgetcsv($fh))
    {
      return $row;
    }

    fclose($fh);
    return false;
  }

  protected function getCon()
  {
    static $con = null;
    if (!is_null($con))
    {
      return $con;
    }

    date_default_timezone_get('Europe/Bucharest');
    $dm = new sfDatabaseManager($this->configuration);

    $con = $dm->getDatabase('doctrine')->getConnection();
    $con->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true);
    return $con;
  }

  protected function getCity($id)
  {
    if (!$this->city)
    {
      $this->city = Doctrine::getTable('City')->find($id);
      $this->lang = getlokalPartner::getDefaultCulture($this->city->getCountry()->getId());
      if (!$this->city)
      {
        throw new Exception('City not found!');
      }
    }

    return $this->city;
  }

  protected function createContext()
  {
    // var_dump($this->configuration); die;
    sfContext::createInstance($this->configuration);
  }


}
