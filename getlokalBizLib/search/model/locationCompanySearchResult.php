<?php
if(!class_exists('webCompanySearchResult')){
    require_once(__DIR__ .'./webCompanySearchResult.php');
}
class locationCompanySearchResult extends webCompanySearchResult
{
    public $distanceFromUser;
    public $isInKm;
}
?>