<?php
if ($argc < 2)
{
  echo 'Incorrect argument count: You must supply the db connection.' . "\n";
  exit(1);
}

$connection = $argv[1];


require_once 'helper.php';

// start processing rows from file
$count = 0;
$sql = "
  SELECT Ci.id, Ci.name AS city, Ci.name_en AS city_en, Co.name as county
  FROM  city Ci
    INNER JOIN county Co ON (Co.id = Ci.county_id)
  WHERE
    Co.country_id = 78
    AND Ci.lng = -99.141968
  LIMIT 100
";
$stmt = $dbh->prepare($sql);
$update = $dbh->prepare("
  UPDATE city SET
    lat = :lat,
    lng = :lng
  WHERE
    id = :id
");

$initial = microtime(true);

while (true) {
  $start = microtime(true);
  // get records
  if (!$stmt->execute()) {
    echo print_r($stmt->errorInfo());
  }

  $records = $stmt->fetchAll();
  if (empty($records)) {
    break;
  }
  $geocoded = array();
  foreach ($records as $c) {
    if ($result = n_geocode_city($c)) {
      $geocoded[] = $result;
    }
  }

  if (!$geocoded) {
    echo sprintf("No cities that need geocoding found!");
    break;
  }

  foreach ($geocoded as $r) {
    try {
      $dbh->beginTransaction();
      $update->execute($r);
      $dbh->commit();
    } catch (Exception $e) {
      $dbh->rollback();
      echo $e->getMessage();
    }
  }

  $count += count($records);
  $time = microtime(true) - $start;
  print("Geocoded {$count} in {$time}s.\n");

  // geocode 1000
  if ($count > 10000) {
    break;
  }
}

$time = microtime(true) - $initial;
echo sprintf("%d companies geocoded in {$time}.\n", $count);

$dbh = null;
