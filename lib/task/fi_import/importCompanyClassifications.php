<?php
	$connectTo = 'live';
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
	extract($connections[$connectTo]);
	global $dbh;
	$dbh = new PDO($DSN, $DSN_USER, $DSN_PASSWORD);
	
	$query =   "SELECT 
					c.id, 
					c.classification_id, 
					cc.id AS hasThisClassification
				FROM `company` c
				LEFT JOIN company_classification cc ON cc.company_id = c.id
				AND cc.classification_id = c.classification_id
				WHERE c.country_id =78
				AND c.external_id LIKE 'FI%'";
	$companies = $dbh->query($query);
	$insertQuery = "INSERT INTO company_classification (`company_id`, `classification_id`) VALUES ";
	$companyClassifications = array();
	foreach ($companies as $company){  
		if( !is_numeric($company['hasThisClassification']) ){
			$companyClassifications[] = "('{$company['id']}', '{$company['classification_id']}')";
		}
	}
	if(sizeof($companyClassifications)){
		$insertQuery .= implode(', ', $companyClassifications).";";
		$dbh->query($insertQuery);
		echo "DONE: ".sizeof($companyClassifications)." classification were inserted. ".PHP_EOL;
	}else{
		echo "DONE: no company classification were inserted. ".PHP_EOL;
	}
	
?>