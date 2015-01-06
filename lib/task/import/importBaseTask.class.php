<?php

class importBaseTask extends sfBaseTask
{
	const SKIP_FIRST_ROW = 1;

	private $_sources = array();
	protected $_fucked_up_cities = array();
	protected $_table_arrays = array();

	protected $_countryId = 0;
	protected $_localLanguage = "";
	protected $_missmatching_companies = array();
	protected $_matching_companies = array();
	protected $_no_classifications_companies = array();
	protected $_distanceBetweenSameCompany = 200;
	
	protected $_databaseManager = null;
	protected $_connection = null;
	
	protected function _createConnection($options){
		if(is_null($this->_databaseManager) && is_null($this->_connection)){
        	echo "connecting do db ...".PHP_EOL;
            $this->_databaseManager = new sfDatabaseManager($this->configuration);
            $this->_connection = $this->_databaseManager->getDatabase($options['connection'])->getConnection();

            var_dump($this->_connection->query('SELECT CONNECTION_ID()')->fetch(PDO::FETCH_ASSOC));
            $wait_timeout = ($this->_connection->query("SHOW VARIABLES LIKE 'wait_timeout'")->fetch(PDO::FETCH_ASSOC));
            $max_allowed_packet = ($this->_connection->query("SHOW VARIABLES LIKE 'max_allowed_packet'")->fetch(PDO::FETCH_ASSOC));
            
            if($wait_timeout['Value'] < 3600 || $max_allowed_packet['Value'] < (20*1024*1024)){
            	die("MySQL server setting are not correct: ".PHP_EOL."wait_timeout: {$wait_timeout['Value']}".PHP_EOL."max_allowed_packet: {$max_allowed_packet['Value']}");
            }
            
        }else{
        	if($this->_databaseManager) echo "_databaseManager already exists".PHP_EOL;
            	if($this->_connection) echo "_connection already exists".PHP_EOL;
        }		
	}
	
	protected function _destroyConnection(){
		$this->_databaseManager = null;
		$this->_connection = null;
	}

	protected function setCountryId($id){
		$this->_countryId = $id;
	}
	protected function setLang($lang){
		$this->_localLanguage = $lang;
	}

	protected function execute($arguments = array(), $options = array()){
	}

	protected function addSource($source_name,$path){
		$filename = sfConfig::get('sf_web_dir') . "/sources/".$path;
		if(file_exists($filename)){
// 			echo "Source is added : '$filename'".PHP_EOL;
			$this->_sources[$source_name]['file'] = $filename;
		}else
			echo "Filename doesn't exist: ' $filename '".PHP_EOL;
	}

	protected function setSourceColumns($source_name,$columns){
		if(isset($this->_sources[$source_name])){
			$this->_sources[$source_name]['columns'] = $columns;
		}else
			echo "Source ' $source_name ' not set in setSourceColumns.".PHP_EOL;
	}
	
	protected function setSourceSeparator($source_name,$separator = ","){
		if(isset($this->_sources[$source_name])){
			$this->_sources[$source_name]['separator'] = $separator;
		}else
			echo "Source ' $source_name ' not set in setSourceSeparator.".PHP_EOL;
	}

	protected function getSourceColumns($source_name){
		return $this->_sources[$source_name]['columns'];
	}
	
	protected function removeSourceColumn($source_name,$column){
		$column_index = array_search($column,$this->_sources[$source_name]['columns']);
		array_splice($this->_sources[$source_name]['columns'],$column_index,1);
	}

	protected function setSourceTable($source_name,$table_name){
		if(isset($this->_sources[$source_name])){
			$this->_sources[$source_name]['table'] = $table_name;
		}else
			echo "Source ' $source_name ' not set.".PHP_EOL;
	}
	
	protected function newSource($source_name,$data){
		$this->_sources[$source_name] = array();
		$this->_sources[$source_name]['data'] = $data;
		$this->_sources[$source_name]['columns'] = array_keys(current($data));
	}

	protected function fetchSourceData($source_name,$from = 0,$to = false){
		$this->_sources[$source_name]['data'] = array(); 
		
		$csvarr = $this->_csvToArray(
				$this->_sources[$source_name]['file'],
				isset($this->_sources[$source_name]['separator']) ? $this->_sources[$source_name]['separator'] : ",");
		//var_dump($csvarr);die;
		foreach($csvarr as $k=>$row){
			if($k < $from)continue;
			if($k > $to && $to !== false)continue;
			$arr = array();
			foreach($this->_sources[$source_name]['columns'] as $i=>$col){
				if(!isset($row[$i])){
					echo "Column with index $i doesn't exists.".PHP_EOL;
// 					var_dump($row,$this->_sources[$source_name]['separator']);
					die;
				}else{
					$arr[$col] = $row[$i];
				}
			}
			$this->_sources[$source_name]['data'][$k] = $arr;
		}
// 		if($skip == self::SKIP_FIRST_ROW){
// 			array_shift($this->_sources[$source_name]['data']);
// 		}
		return $this->_sources[$source_name]['data'];
	}

	protected function getSourceData($source_name){
		if(isset($this->_sources[$source_name])){
			if(isset($this->_sources[$source_name]['data']))
				return $this->_sources[$source_name]['data'];
			else
				echo "You must first fetch the data from source. ($source_name)".PHP_EOL;
		}else{
			echo "Source ' $source_name ' not set in getSourceData.".PHP_EOL;
		}
	}

	protected function getSourceDataCount($source_name){
		if(isset($this->_sources[$source_name])){
			return sizeof($this->_sources[$source_name]['data']);
		}else{
			echo "Source ' $source_name ' not set in getSourceDataCount.".PHP_EOL;
		}
	}

	protected function filterSourceData($source_name,$callback,$execute = false){
		if($execute){
			$this->_sources[$source_name]['data'] = array_filter($this->_sources[$source_name]['data'] , $callback);
		}else{
			$this->_sources[$source_name]['filters_and_mappers'][] = array("filter"=>$callback);
		}
	}

	protected function mapSourceData($source_name,$callback,$execute = false){
		if($execute){
			$data = $this->_sources[$source_name]['data'];
			$this->_sources[$source_name]['data'] = array_map($callback , $data,array_keys($data));
		}else{
			$this->_sources[$source_name]['filters_and_mappers'][] = array("mapper"=>$callback);
		}
	}
	
	protected function executeAllFiltersAndMappers($source_name){
		$source = &$this->_sources[$source_name];
		foreach($source['data'] as $key=>$row){
			foreach($source['filters_and_mappers'] as $k=>$arr){
//				echo "executing index $k ... ";
//				$time = microtime(true);
				if(isset($arr['filter'])){
//					echo "filter";
					if(!$arr['filter']($row)){
						unset($source['data'][$key]);break;
					}
				}
				if(isset($arr['mapper'])){
//					echo "mapper";
					$row = $arr['mapper']($row);
					$source['data'][$key] = $row;// both lines needed
				}
//				echo " done (".(microtime(true)-$time)."s)".PHP_EOL;
			}
// 			echo PHP_EOL;
		}
	}
	
	protected function multiplySourceData($source_name,$callback){
		$data = array();
		foreach($this->_sources[$source_name]['data'] as $row){
			$data = array_merge($data,$callback($row));
		}
		$this->_sources[$source_name]['data'] = $data;
	}

	protected function bulkInsert($source_name,$columns = false){

// 		$this->mapSourceData($source_name, $this->getSlugToLowerMapper());


		//strips array_keys that are not in columns array
		$insert_data = $columns ? array_map(function($row) use($columns){
			foreach(array_keys($row) as $key){
				if(!in_array($key,$columns)){
					unset($row[$key]);
				}
			}
			return $row;
		},$this->_sources[$source_name]['data']) : $this->_sources[$source_name]['data'];

		if(!$insert_data){
			return "";
		}
		echo "TRYING TO INSERT ".sizeof($insert_data).PHP_EOL;
		$q = $this->_bulkInsert(
			 $insert_data,
			 $this->_sources[$source_name]['table'],
			 array_keys(current($insert_data)));

		$this->_sources[$source_name]['query'] = $q;
		return $q;
	}

	protected function _csvToArray($source,$separator = ","){
		$result = array();
		if (($handle = fopen($source, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
				$result[] = $data;
			}
			fclose($handle);
		}
		return $result;
	}

	protected function _bulkInsert($data, $table = null, $columns = null, $limit = null){
		$recordset = array();
		$values = array();
		$queries = array();
		$queryFirst = "";
		if(is_null($limit)){
			$limit = 1000;
		}
		if(!is_null($table) && !is_null($columns)){
			sort($columns);
			$keys = "`".implode('`,`', $columns)."`";
			$queryFirst = "INSERT INTO `$table` ($keys) VALUES ";
		}
		$count = 1;
		foreach ($data as $item){
			ksort($item);
			foreach ($item as $key => $value){
				$item[$key] = addslashes($value);
			}
			$recordset[] = "( '".implode("', '", $item)."' )";
			if($count % $limit == 0){
				$values[] = $recordset;
				$recordset = array();
			}
			$count++;
		}
		if(sizeof($recordset)){
			$values[] = $recordset;
		}
		foreach ($values as $v){
			$queries[] = $queryFirst."".implode(", ", $v);
		}

		return $queries;
	}

	protected function executeSource($source_name){
		if(!empty($this->_sources[$source_name]['query'])){
			$conn = $this->_connection;			
			$i = 0;
			$queryCount = 10;
			$conn->beginTransaction();
			foreach($this->_sources[$source_name]['query'] as $q){
				if($i % $queryCount == $queryCount-1){
					echo "Commiting-".($i / $queryCount).PHP_EOL;
					$conn->commit();
					echo "Starting transation-".(($i / $queryCount) + 1).PHP_EOL;
					$conn->beginTransaction();
				}
				$i++;
				echo substr($q,0,200).PHP_EOL;
				try
				{
					$stm = $conn->prepare($q);
					$stm->execute();
				}
				catch ( PDOException $e )
				{
					echo 'Code : ' . $e->getCode();
					echo 'Message : ' . $e->getMessage();
				}
			}
			$conn->commit();
		}else{
			echo "source query is empty";
		}
	}
	
	protected function executeBulk($bulk){
		var_dump($bulk);
		if($bulk){
			$this->_connection->prepare("START TRANSACTION")->execute();
			foreach($bulk as $q){
				$this->_connection->prepare($q)->execute();// works
			}
			$this->_connection->prepare("COMMIT")->execute();
		}
	}

	protected function generateCompanySlug($title){
		// 		echo "Generating Slug ...".PHP_EOL;
		$new_slug = $slug = CityTable::slugify($title);

		$arr = $this->getTableArray("slugs","ones");

		for($i=0;;$i++){
			$sufix = $i === 0 ? "" : "-$i";
			$char = substr($new_slug,0,1);
			if(!isset($arr[$char][$new_slug.$sufix])){
				$new_slug = $new_slug.$sufix;
				break;
			}
		}
// 		$this->_table_arrays['slugs']['origin'][] = $new_slug;
		$this->_table_arrays['slugs']['ones'][$char][$new_slug] = 1;
		// 		echo "New slug is: $new_slug".PHP_EOL;

		return $new_slug;
	}

	private function _escapeSpecialChars($pTerm)
	{
		$from = array ( '\\', '(',')','|','-','!','@','~','"','&', '/', '^', '$', '=' );
		$to   = array ( '\\\\\\', '\\\(','\\\)','\\\|','\\\-','\\\!','\\\@','\\\~','\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=' );

		return str_replace ( $from, $to, $pTerm );
	}

	protected function getSlug($string){
		return CityTable::slugify($string);
		//return $this->cleanSlugString($this->toLatin($string));
	}

	protected function cleanSlugString($slugString)	{
		$cleanSlug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $this->replaceDiacritics($slugString)));
		return $cleanSlug;
	}

	protected function toLatin($str){
		$theArray = array (
				'à' => 'a','á' => 'a','â' => 'a','ã' => 'a','ä' => 'a','å' => 'a','ā' => 'a',
				'ă' => 'a','ç' => 'c','ć' => 'c','ĉ' => 'c','è' => 'e','é' => 'e','ê' => 'e',
				'ë' => 'e','ì' => 'i','í' => 'i','î' => 'i','ï' => 'i','ò' => 'o','ó' => 'o',
				'ô' => 'o','õ' => 'o','ö' => 'o','ő' => 'o','ù' => 'u','ú' => 'u','û' => 'u',
				'ü' => 'u','ý' => 'y','ÿ' => 'y',	'Á' => 'A','Å' => 'A','Â' => 'A','Ä' => 'A',
				'À' => 'A','Ã' => 'A',	'Ā' => 'A','Ă' => 'A','Č' => 'C','Ç' => 'C','Ć' => 'C',
				'Ċ' => 'C',	'È' => 'E',	'É' => 'E','Ê' => 'E','Ë' => 'E',	'Ì' => 'I','Í' => 'I',
				'Î' => 'I','Ï' => 'I',	'Õ' => 'O',	'Ö' => 'O','Ò' => 'O','Ó' => 'O','Ô' => 'O',
				'Ő' => 'O','Ø' => 'O','Ù' => 'U','Ú' => 'U','Û' => 'U','Ü' => 'U','Ý' => 'Y',
				'Š' => 'S',	'š' => 's','Đ' => 'Dj',	'đ' => 'dj','Ž'=>'Z','ž'=>'z','e' => 'e',
				'E' => 'E',	'e' => 'e','E' => 'E','e' => 'e','G' => 'G','g' => 'g','G' => 'G',
				'g' => 'g','G' => 'G','g' => 'g','G' => 'G','g' => 'g','H' => 'H','h' => 'h',
				'H' => 'H','h' => 'H','I' => 'I','i' => 'i','I' => 'I','i' => 'i','I' => 'I',
				'i' => 'i','I' => 'I','i' => 'i','I' => 'I','J' => 'J','j' => 'j','K' => 'K',
				'k' => 'k','L' => 'L','l' => 'l','N' => 'N','n' => 'n','N' => 'N','n' => 'n',
				'N' => 'N','n' => 'n','O' => 'O','o' => 'o','O' => 'O','o' => 'o','O' => 'O',
				'o' => 'o','R' => 'R','ŕ' => 'r','Ŗ' => 'R','ŗ' => 'r','Ř' => 'R','ř' => 'r',
				'Ś' => 'S','ś' => 's','Ŝ' => 'S','ŝ' => 's','Ş' => 'S','ş' => 's','Š' => 'S',
				'š' => 's','Ţ' => 'T','ţ' => 't','Ť' => 'T','ť' => 't','Ŧ' => 'T','ŧ' => 't',
				'Ũ' => 'U','ũ' => 'u','Ū' => 'U','ū' => 'u','Ŭ' => 'U','ŭ' => 'u','Ů' => 'U',
				'ů' => 'u','Ű' => 'U','ű' => 'u','Ų' => 'U','ų' => 'u','Ŵ' => 'W','ŵ' => 'w',
				'Ŷ' => 'Y','ŷ' => 'y','Ÿ' => 'Y','Ź' => 'Z','ź' => 'z','Ż' => 'Z','ż' => 'z',
				'Ž' => 'Z','ž' => 'z','ſ' => 'F','ƒ' => 'f','Ơ' => 'O','ơ' => 'o','Ư' => 'U',
				'ư' => 'u','Ǎ' => 'A','ǎ' => 'a','Ǐ' => 'I','ǐ' => 'i','Ǒ' => 'O','ǒ' => 'o',
				'Ǔ' => 'U','ǔ' => 'u','Ǖ' => 'U','ǖ' => 'u','Ǘ' => 'U','ǘ' => 'u',
				'Ǚ' => 'U','ǚ' => 'u','Ǜ' => 'U','ǜ' => 'u','Ǻ' => 'A',
				'ǻ' => 'a','Ǽ' => 'AE','ǽ' => 'ae','Ǿ' => 'o','ǿ' => 'o',
		);
		$result = $str;
		$result = strtr($result, $theArray);

		return $result;
	}

	protected function replaceDiacritics($text)
	{
		$from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
		$to = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


		$cyr  = array('ИЯ','Ия','ия','а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у',
				'ф','х','ц','ч','ш','щ','ъ','ь', 'ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У',
				'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я' );

		$lat = array( 'IA', 'Ia', 'ia', 'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
				'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'a' ,'y' ,'yu' ,'ya','A','B','V','G','D','E','Zh',
				'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
				'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'A' ,'Y' ,'Yu','Ya' );

		$text = str_replace($from, $to, $text);
		$text = str_replace($cyr, $lat, $text);

		return $text;
	}
	/*===========================================================================
	 ============================= DB TABLE AS ARRAYS ==================================
	=================================================================================*/

	protected function getTableArray($name,$key = "origin",$index = false){
		if(isset($this->_table_arrays[$name][$key])){
			if($index !== false){
				if($key == "origin"){
					$prefix = $index%100;
					if(!isset($this->_table_arrays[$name][$key][$prefix][$index])){
						echo "this->_table_arrays[$name][$key][$prefix][$index] doesn't exists".PHP_EOL;
						return false;
					}
					return $this->_table_arrays[$name][$key][$prefix][$index];
				}else{
					if($name == "cities" && $key == "by_external_id"){
						$char = substr($index,-1);
					}else{
						$char = substr($index,0,1);
					}
					if(isset($this->_table_arrays[$name][$key][$char][$index])){
						return $this->_table_arrays[$name][$key][$char][$index];
					}else{
						return false;
					}
				}
				
			}else{
				return $this->_table_arrays[$name][$key];
			}
		}else{
			echo "\$this->_table_arrays[{$name}][{$key}] doesn't exist".PHP_EOL;
			return false;
		}
	}

	protected function loadTableArray($name,$sql,$by_array = array('id')){
		$table = $this->_connection->prepare($sql);
		$table->execute();

		// init arrays
		if(!isset($this->_table_arrays[$name]['origin'])){
			$this->_table_arrays[$name]['origin'] = array();
		}
		foreach($by_array as $key=>$label){
			if(is_numeric($key)) $key = $label;
			if(!isset($this->_table_arrays[$name]["by_$label"])){
				$this->_table_arrays[$name]["by_$label"] = array();
			}
		}

		while ($row = $table->fetch()) {
			if($row){
				$prefix = $row['id']%100;
				
				$this->_table_arrays[$name]['origin'][$prefix][$row['id']] = $row;

				foreach($by_array as $key=>$label){
					if(is_numeric($key)) $key = $label;
					if($key == "id")continue;
						
					$table_key = $row[$key];
					$table_arr = &$this->_table_arrays[$name]["by_$label"];
					if($name == "cities" && $label == "external_id"){
						$char = substr($table_key,-1);
					}else{
						$char = substr($table_key,0,1);
					}

					if($name == "companies"	&& $label == "name" && isset($table_arr[$char][$table_key])){
						if(is_array($table_arr[$char][$table_key])){
							$table_arr[$char][$table_key][] = $row['id'];
						}else{
							$table_arr[$char][$table_key] = array($table_arr[$char][$table_key],$row['id']);
						}
					}else{
						$table_arr[$char][$table_key] = $row['id'];
					}
				}
			}
		}
	}

	protected function _getCurrentCompaniesSlug(){
		$sql = "SELECT
				c.slug
				FROM `company` c";

		$currentCompanies = $this->_connection->prepare($sql);
		$currentCompanies->execute();
// 		$this->_table_arrays["slugs"]["origin"] = array();
		$this->_table_arrays["slugs"]["ones"] = array();
		$this->_currentCompaniesSlug = '|';

		while ($company = $currentCompanies->fetch()) {
// 			$this->_table_arrays["slugs"]["origin"][] = $company['slug'];
			$char = substr($company['slug'],0,1);
			$this->_table_arrays["slugs"]["ones"][$char][$company['slug']] = 1;
			$this->_currentCompaniesSlug .= "{$company['slug']}|";
		}
	}

	protected function _getCurrentCompanies($last_hour = false){
		$sql = "SELECT
		c.id,
		c.slug,
		c.external_id,
		ct.title AS companyTitle,
		cl.latitude,
		cl.longitude ".
// 		cl.street,
// 		cl.street_number,
// 		cl.entrance,
// 		cl.floor,
// 		city.id AS cityId,
// 		city.external_id AS cityExternalId,
// 		cityt.name AS cityName
		"FROM `company` c
		LEFT JOIN `company_translation` ct
		ON ct.id=c.id AND ct.lang='{$this->_localLanguage}'
		LEFT JOIN `company_location` cl
		ON cl.id=c.location_id ".
// 		LEFT JOIN `city`
// 		ON city.id=c.city_id
// 		LEFT JOIN `city_translation` cityt
// 		ON cityt.id=c.city_id AND cityt.lang='{$this->_localLanguage}'
		"WHERE c.country_id=".$this->_countryId;

		$last_hour_date = date('Y-m-d H:i:s', strtotime('-1 day'));
		if($last_hour){
			$sql.= " AND c.created_at > '$last_hour_date'";
		}
		// 		echo $sql;die;
		$this->loadTableArray("companies", $sql,array("id",'companyTitle'=>"name","slug","external_id"));
	}

	protected function _getCurrentCities(){
		$sql = "SELECT
				c.id,
				c.slug,
				c.external_id,
				c.county_id,
				c.lat as latitude,
				c.lng as longitude,
				ct.name
				FROM `city` c
				JOIN county cn
				ON cn.id=c.county_id
				LEFT JOIN city_translation ct
				ON ct.id=c.id
				WHERE cn.country_id=".$this->_countryId;
		$this->loadTableArray("cities", $sql,array("id","name","slug","external_id"));

	}

	protected function _getCurrentClassifications(){
		$sql = "SELECT
		s.id,
		s.category_id,
		s.external_id,
		st.title,
		s.sector_id
		FROM `classification` s
		LEFT JOIN `classification_translation` st
		ON st.id=s.id AND st.lang='{$this->_localLanguage}'
		ORDER BY s.id DESC";

		$this->loadTableArray("classifications", $sql,array("id","title"=>"name","external_id"));
	}
	
	protected function _getCurrentSectors(){
		$sql = "SELECT
			s.id,
			st.title,
			st.rank
		FROM `sector` s
		LEFT JOIN `sector_translation` st
			ON st.id=s.id AND st.lang='{$this->_localLanguage}'
		ORDER BY s.id DESC";
	
		$this->loadTableArray("sectors", $sql,array("id","title"=>"name"));
	}

	protected function _getCurrentCounties(){
		$sql = "SELECT
				co.id,
				co.slug,
				cotr.name,
				co.external_id
				FROM county co
				LEFT JOIN county_translation cotr ON cotr.id = co.id
				WHERE co.country_id = ".$this->_countryId;

		$this->loadTableArray("counties", $sql,array("id","name","slug","external_id"));
		$this->_table_arrays['counties']['origin'] = array_map(function($row){
			$row['name'] = str_ireplace('district', '', $row['name']);
			$row['name'] = trim($row['name']);
			return $row;
		}, $this->_table_arrays['counties']['origin']);
	}

	/////////////////////// FILTERS & MAPPERS ////////////////////////////////////

	protected function getLangFilter($lang){
		return function($row) use($lang){
			if($row['lang'] != $lang){
				return 0;
			}else{
				return 1;
			}
		};
	}

	protected function getIsActiveMapper($is_active){
		return function($row) use($is_active){
			$row['is_active'] = $is_active;
			return $row;
		};
	}

	protected function getCheckSlugMapper(){
		return function($row){
			if(isset($row['slug'])){
				$generated_slug = $this->getSlug($row['slug']);
				if($row['slug'] != $generated_slug){
					echo "Different than generated : ".$row['slug']." - ".$generated_slug.PHP_EOL;
					$row['slug'] = $generated_slug;
				}
			}
			return $row;
		};
	}

	protected function getSlugToLowerMapper(){
		return function($row){
			if(isset($row['slug'])){
				$row['slug'] = strtolower($row['slug']);
			}
			return $row;
		};
	}
	
	protected function getLatLngFromCityMapper(){
		return function($company){
			$company['city_id'] = $this->_getCityId($company);
			
			if($company['city_id'] === false){
				$this->missmatching_companies[] = $company;
			}else{
				if(!$company['latitude'] && !$company['longitude']){
					$city = $this->getTableArray("cities","origin",$company['city_id']);
					$company['latitude'] = $city['latitude'];
					$company['longitude'] = $city['longitude'];
				}
			}
			return $company;
		};
	}
	
	protected function getMatchingAndNoCityFilter($count = false){
		return function($company) use ($count){
			global $counter;
			$counter++;
  			if($count && $counter >$count){
  				return false;
  			}
			if($company['city_id'] === false){
				$this->_missmatching_companies[] = $company;
// 				echo "Company ignored because of no city_id".PHP_EOL;
				return false;
			}
			//if($this->_checkIfCompaniesMatch($company)){
// 				echo "Company ignored because of matching lat lng and name".PHP_EOL;
				//   	  			$matching++;
			//	$this->_matching_companies[] = $company;
			//	return false;
			//}else{
				return true;
			//}
		
		};
	}
	
	protected function getNoClassificationFilter(){
		return function($company){
			if(!$company['sector_id'] || !$company['classification_id']){
				$this->_no_classifications_companies[] = $company;
				return false;
			}else{
				return true;
			}
		};
	}
	
	protected function getInsertedIdsFilter(){
// 		$companies_by_slug = $this->getTableArray("companies","by_slug");
		return function($company){
			$char = substr($company['slug'],0,1);
			$company['id'] = (int)$this->getTableArray("companies","by_slug",$company['slug']);
			if($company['id']){
// 				echo "INSERT WAS SUCCESSFULL ID FOUND".PHP_EOL;
			}else{
				echo "ERROR: CANT FIND COMPANY BY SLUG {$company['slug']} PROBABLY INSERT WASNT SUCCESSFULL".PHP_EOL;
			}
			return $company;
		};
	}


	protected function _getCityId($company){
		if(isset($company['city_ext_id'])){
			$id = $this->getTableArray("cities","by_external_id",$company['city_ext_id']);
			if($id)return $id;
		}
		if(isset($company['city'])){
			$id = $this->getTableArray("cities","by_name",$company['city']);
			if($id)return $id;
		}
// 		if(isset($this->_fucked_up_cities[$company['city']])){
// 			$this->_fucked_up_cities[$company['city']] ++;
// 		}else{
// 			$this->_fucked_up_cities[$company['city']] = 1;
// 		}
// 		echo "NO CITY ID FOR COMPANY WITH CITY '{$company['city']}' AND CITY_EXT_ID '{$company['city_ext_id']}'";
		return false;
	}

	protected function _getCountyId($company){
		if(empty($company['county_ext_id'])){
			return $this->_table_arrays['counties']['by_name'][$company['county']];
		}else{
			return $this->_table_arrays['counties']['by_external_id'][$company['county_ext_id']];
		}
	}

	protected function _checkIfCompaniesMatch($company){
// 		echo PHP_EOL.PHP_EOL;
		$s = sizeof($this->getTableArray("companies","by_name"));
// 		echo "CHECKING IF {$company['title']} EXISTS IN ARRAY($s)".PHP_EOL;

		if($company_ids = $this->getTableArray("companies","by_name",$company['title'])){
// 			echo "DO EXISTS".PHP_EOL;
			foreach((array)$company_ids as $currentCompanyId){
// 				echo "currentCompanyId is : $currentCompanyId".PHP_EOL;
				$currentCompany = $this->getTableArray("companies","origin",$currentCompanyId);
					
				$lat1 = (float)$currentCompany['latitude'];
				$lng1 = (float)$currentCompany['longitude'];
				$lat2 = (float)$company['latitude'];
				$lng2 = (float)$company['longitude'];
					
// 				echo "LAT1 : {$lat1},LNG1 : {$lng1}, LAT2 : {$lat2},LNG2 : {$lng2}".PHP_EOL;
				$metersBetween = $this->_getDistance($lat1, $lng1, $lat2,$lng2);
// 				echo "METERS BETWEEN : $metersBetween".PHP_EOL;
				if($metersBetween < $this->_distanceBetweenSameCompany || is_nan($metersBetween)){
					return true;
				}
			}
		}
		return false;
	}

	protected function _getDistance($lat1, $lon1, $lat2, $lon2, $unit = "M") {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "M") {
			return ($miles * 1609.344);
		} else {
			return $miles;
		}
	}
}