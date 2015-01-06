<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

mysql_connect('localhost', 'root', 'lostsoul') or die(mysql_error());
mysql_select_db('bla') or die(mysql_error());


$arr = array(
  'company',
  'page_admin',
  'product',
  'orders',
  'place_game',
  'slider',
  'mobile_news',
  'get_weekend',
  'review',
  'event',
  'image',
  'category',
  'classification',
  'static_page',
  'newsletter',
  'newsletter_user',
  'badge',
  'user_admin',
  'permission_admin',
);

foreach($arr as $perm)
{
  foreach(array('ro' => 'Romania', 'bg' => 'Bulgaria', 'mk' => 'Makedonia') as $cc => $country)
  {
    $name = $perm.'_'.$cc;
    $clean = ucwords(str_replace('_', ' ', $perm));
    
    mysql_query("INSERT INTO `sf_guard_permission` VALUES (NULL ,  '{$name}',  'Administer {$clean} options for {$country}',  ".ProjectConfiguration::nowAlt(1).",  ".ProjectConfiguration::nowAlt(1).");") or die(mysql_error());
  }
    
}