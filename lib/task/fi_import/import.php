<?php
include '../../utils/TransliterateFi.php';
$connection = 'live';
$file = 'companies_2.1.csv';
// $city_id = $culture = null;
// if ($argc > 2)
// {
//   $city_id = $argv[2];
// }
// if ($argc > 3)
// {
//   $culture = $argv[3];
// }
echo "Inserting on $connection".PHP_EOL;
$fields = array(
  'id',
  'title',
  'title_en',
  'classification_id',
  'sector_id',
  'phone',
  'city',
  'county',
  'email',
  'website_url',
  'foursquare_url',
  'twitter_url',
  'facebook_url',
  'facebook_id',
  'company_type',
  'registration_no',
  # if possible the following, otherwise left blank
  'location_type',
  'street_type',
  'street_number',
  'street',
  'neighbourhood',
  'building_no',
  'entrance',
  'floor',
  'appartment',
  'postcode',
  'full_address',
  'address_info',
  'latitude',
  'longitude',
  'accuracy',

  # extra fields
  'establishment_date',  // day of establishment
  'registration_date',   // day of registrition
  'company_form',        // Juridical form of company
  'business_type',       // Yhtiömuoto (this means type of business J)
  'nace_code',           // Main heading NACE code
  'personal_abount',     // Abount of personal
  'personal_year',        // Year reported of personal
  'turnover',            // Turnover
  'turnover_year',       // Year of turnover
  'tax_reg',             // Existing in taxation reg.
  'financial_risk',      // Financial risk classification
  'source',              // Source of information
);

require_once 'helper.php';
create_extra_table();

$count = 0;
// start processing rows from file
try {
  $dbh->beginTransaction();
  while ($row = get_row())
  {
    // geocode($row);
    insert_row($row);
	
    $count++; 
    /*if($count>1){
    	break;
    } */  
  }
  $dbh->commit();
} catch (Exception $e) {
  $dbh->rollback();
  echo $e->getMessage();
}


echo sprintf("%d companies added to the database.", $count);
$dbh = null;
