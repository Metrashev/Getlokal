<?php

require_once('model/SearchFilter.php');
require_once('SearchProviderCompany.php');

interface iSearchProvider
{
    public function SetPageSize($pPageSize);
    public function getReturnedMatches();
    public function getTotalMatches();
    public function getLog();
    public function getLanguage();

    public function locationGetACCity($pTerm, &$pErrors, $pLimit=null);
    public function locationGetACCounty($pTerm, &$pErrors, $pLimit=null);
    public function locationGetACCountry($pTerm, &$pErrors, $pLimit=null);

    /**
     * Searches by geo points.
     * First point - represented by $pSearchCenterLang, $pSearchCenterLong is the search center
     * Second point - represented by $pUserLang, $pUserLong is the user's center
     * First point = Second point when the user is in the center of search or user's coordinates are not provided by the device.
     * First point differs from Second point when the user searches in other locations then their current.
     *      In that case the center of the map is given as First Point.
     *
     * NOTE: Objects are ordered by the distance from the user's location (Second point) and keyword weight.
     * Shown distance(km/mi) is calculated regarding Second point.
     */
    public function searchCompaniesByGeoPoint($pSearchCenterLat,
                                              $pSearchCenterLong,
                                              $pUserLat,
                                              $pUserLong,
                                              $showInKm,
                                              &$pErrors,
                                              SearchFilter &$pFilter);

    public function searchCompaniesByCityId($pCityId, &$pErrors, SearchFilter &$pFilter);
    public function searchCompaniesByCountyId($pCountyId, &$pErrors, SearchFilter &$pFilter);
    public function searchCompaniesByCountryId($pCountryId, &$pErrors, SearchFilter &$pFilter);
}
?>