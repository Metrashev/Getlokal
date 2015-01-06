<?php

require_once('model/SearchResult.php');
require_once(__DIR__ . '/../dbTools/DbConnection.php');
require_once('SearchDataMode.php');
require_once('iSearchProvider.php');
require_once(__DIR__ .'/../images/iImagePathFormatter.php');
require_once(__DIR__ .'/../images/imageSize.php');


class SearchManager
{
    private $_searchProvider;
    private $_imageFormatter;
    private $_dbConnection;
    private $_dataMode;
    private $_doTrace;
    private $_currentUserId;

    public function __construct(iSearchProvider &$pSearchProvider,
                                DbConnection &$pDbConnection,
                                iImagePathFormatter &$pImageFormatter,
                                $pUserId)
    {
        $this->_searchProvider = $pSearchProvider;
        $this->_dbConnection = $pDbConnection;
        $this->_dataMode = SearchDataMode::webSearchResultList;
        $this->_doTrace = false;
        $this->_currentUserId = $pUserId;
        $this->_imageFormatter = $pImageFormatter;

        $this->_dbConnection->setCharset("utf8");
        $this->_dbConnection->setGroupConcatLen(1000000);
    }

    public function setDataMode($pMode)
    {
        $this->_dataMode = $pMode;
    }

    public function setTrace($pDoTrace)
    {
        $this->_doTrace = $pDoTrace;
    }

    public function getTrace()
    {
        return $this->_searchProvider->getLog();
    }

    public function locationGetACCity($pTerm, $pLimit=null)
    {
        $errors = '';
        $models = $this->_searchProvider->locationGetACCity($pTerm, $errors, $pLimit);
        return $this->prepareLocationsSerchResult($models, $errors);
    }

    public function locationGetACCounty($pTerm, $pLimit=null)
    {
        $errors = '';
        $models = $this->_searchProvider->locationGetACCounty($pTerm, $pErrors, $pLimit);
        return $this->prepareLocationsSerchResult($models, $errors);
    }

    public function locationGetACCountry($pTerm, $pLimit=null)
    {
        $errors = '';
        $models = $this->_searchProvider->locationGetACCountry($pTerm, $pErrors, $pLimit);
        return $this->prepareLocationsSerchResult($models, $errors);
    }

    public function searchCompaniesByGeoPoint($pSearchCenterLat, $pSearchCenterLong, $pUserLat, $pUserLong, $pRadius, $showInKm, SearchFilter &$pFilter)
    {
        $errors = '';
        $companies = $this->_searchProvider->searchCompaniesByGeoPoint(
                        $pSearchCenterLat,$pSearchCenterLong, $pUserLat, $pUserLong,
                        $pRadius, $showInKm, $errors, $pFilter);

        return $this->prepareCompanySearchResults($companies, "locationCompanySearchResult", $errors, $showInKm);
    }

    public function searchCompaniesByCityId($pCityId, SearchFilter &$pFilter)
    {
        $errors = '';
        $companies = $this->_searchProvider->searchCompaniesByCityId($pCityId, $errors, $pFilter);
        return $this->prepareCompanySearchResults($companies, "webCompanySearchResult", $errors);
    }

    public function searchCompaniesByCountyId($pCountyId, SearchFilter &$pFilter)
    {
        $errors = '';
        $companies = $this->_searchProvider->searchCompaniesByCountyId($pCountyId, $errors, $pFilter);
        return $this->prepareCompanySearchResults($companies, "webCompanySearchResult", $errors);
    }

    public function searchCompaniesByCountryId($pCountryId, SearchFilter &$pFilter)
    {
        $errors = '';
        $companies = $this->_searchProvider->searchCompaniesByCountryId($pCountryId, $errors, $pFilter);
        return $this->prepareCompanySearchResults($companies, "webCompanySearchResult", $errors);
    }

    private function prepareLocationsSerchResult(&$arrayOfObjectsToReturn, &$errors)
    {
        $res = new SearchResult();

        $res->errors = $errors;
        $res->searchResultModels = $arrayOfObjectsToReturn;
        $res->totalReturned = $this->_searchProvider->getReturnedMatches();

        if($this->_doTrace)
            $res->trace .= $this->_searchProvider->getLog();

        return $res;
    }

    private function prepareCompanySearchResults(&$matchedCompanies, $resultType, $errors, $isInKm = true)
    {
        $result = new SearchResult();
        $result->totalReturned = 0;

        if(!$matchedCompanies)
        {
            $result->errors = $errors;
        }
        else
        {
            $assocComp = array();
            $compIds = '';
            foreach($matchedCompanies as $comp)
            {
                if($compIds != '')
                    $compIds .=',';

                $compIds .= $comp->Id;

                $model = null;
                if($resultType == "locationCompanySearchResult")
                {
                    $model = new locationCompanySearchResult();
                    $model->distanceFromUser = $comp->distanceFomUser;
                    $model->isInKm = $isInKm;
                }
                else
                    $model = new webCompanySearchResult();

                $model->id = $comp->Id;
                $model->title = $comp->Title;
                $model->rank = $comp->StarRating;
                $model->address = $comp->Address;
                $model->sectorId = $comp->SectorId;
                $model->classificationId = $comp->ClassificationId;
                $model->isPPP = $comp->IsPPP;
                $model->latitude = $comp->Latitude;
                $model->longitude = $comp->Longitude;
                //$model->offersCount = $comp->

                $assocComp[$comp->Id] = $model;
            }

            $query = '';
            $offersQuery = '';

            $this->prepareDbQueries($compIds, $query, $offersQuery);
            if($query != '')
            {
                try
                {
                    $dbRes = $this->_dbConnection->query($query);

                    while($row = mysqli_fetch_assoc($dbRes))
                    {
                        $cmp = $assocComp[$row['c_id']];
                        $cmp->reviewsCount = $row['number_of_reviews'];
                        $cmp->slug = $row['company_slug'];
                        $cmp->classificationName = $row['classificationTitle'];
                        $cmp->classificationSlug = $row['classificationSlug'];
                        $cmp->pppReviewPicture = $this->_imageFormatter->getCompanyUrl($row['company_img'], imageSize::SMALL_THUMB, $this->_currentUserId, $this->_searchProvider->getLanguage());
                        $cmp->favorite = $row['follow'];
                        $cmp->phone = $row['phone'];
                        $cmp->citySlug = $row['city_slug'];

                        if($assocComp[$row['company_id']]->isPPP)
                        {
                            $cmp->pppReviewId = $row['review_id'];
                            $cmp->pppReviewText = $row['text'];
                            $cmp->pppReviewPicture = $this->_imageFormatter->getProfileUrl($row['rev_user_img'], imageSize::SMALL_THUMB, $this->_currentUserId, $this->_searchProvider->getLanguage());
                        }
                    }

                    if($offersQuery != '')
                    {
                        $dbOffersRes = $this->_dbConnection->query($offersQuery);

                        while($offerRow = mysqli_fetch_assoc($dbOffersRes))
                        {
                            if(!$assocComp[$row['company_id']]->isPPP)
                                continue;

                            if(!isset($assocComp[$offerRow['company_id']]))
                                $assocComp[$offerRow['company_id']]->offers = array();

                            $offer = new companyOfferSearchResult();
                            $offer->id = $offerRow['id'];
                            $offer->companyId = $offerRow['company_id'];
                            $offer->code = $offerRow['code'];
                            $offer->maxVouchers = $offerRow['max_vouchers'];
                            $offer->maxUserVouchers = $offerRow['max_per_user'];
                            $offer->vouchersCount = $offerRow['count_voucher_codes'];
                            $offer->title = $offerRow['title'];
                            $offer->picture = $this->_imageFormatter->getOfferUrl($offerRow['filename'], imageSize::PORTRAIT, $this->_currentUserId, $this->_searchProvider->getLanguage());

                            $assocComp[$offerRow['company_id']]->offers[] = $offer;
                        }
                    }
                }
                catch(Exception $ex)
                {
                    $result->errors = $ex->getMessage();
                }
            }

            if($result->errors == '')
            {
                $result->searchResultModels = array_values($assocComp);
                $result->totalReturned = $this->_searchProvider->getTotalMatches();
            }

            if($this->_doTrace)
                $result->trace .= $this->_searchProvider->getLog();
        }

        return $result;
    }

    private function prepareDbQueries($pCompanyIdsArray, &$pQuery, &$pOffersQuery)
    {
        $lang = $this->_searchProvider->getLanguage();
        $pQuery = '';
        $pOffersQuery = '';

        switch($this->_dataMode)
        {
            case SearchDataMode::webAutocompleteList:
                //No extra data needed at that stage
                break;

            case SearchDataMode::webSearchResultList:
            case SearchDataMode::locationSearchResultList:
                $pQuery = "select
                            `C`.`id` AS `c_id`,
                            `IMG_CMP`.`filename` AS `company_img`,
                            COALESCE(`FOL`.`id`, 0, 1) AS `follow`,
                            `C`.`number_of_reviews`,
                            `C`.`review_id`,
                            `REV`.`text`,
                            `IMG`.`filename` AS `rev_user_img`,
                            `C`.`phone`,
                            `CI`.`slug` AS `city_slug`,
                            `C`.`slug` AS `company_slug`,
                            COALESCE(`classTransCur`.`title`, `classTrans`.`title`) AS classificationTitle,
                            COALESCE(`classTransCur`.`slug`, `classTrans`.`slug`) AS classificationSlug
                        from `company` `C`
                            join `city` `CI` ON `C`.`city_id` = `CI`.`id`
                            left join `page` `PAGE` ON `C`.`id` = `PAGE`.`foreign_id` AND `PAGE`.`type` = 1
                            left join `follow` `FOL` ON `PAGE`.`id` = `FOL`.`page_id` AND `FOL`.`user_id` = {$this->_currentUserId}
                            left join `image` `IMG_CMP` ON `C`.`image_id` = `IMG_CMP`.`id` AND `IMG_CMP`.`type` = 'company'
                            left join `review` `REV` ON `C`.`review_id` = `REV`.`id`
                            left join `image` `IMG` ON `REV`.`user_id` = `IMG`.`user_id` AND `IMG`.`type` = 'profile'
                            left join `classification_translation` `classTrans` ON `C`.`classification_id` = `classTrans`.`id` AND `classTrans`.`lang` = 'en'
                            left join `classification_translation` `classTransCur` ON `C`.`classification_id` = `classTransCur`.`id` AND `classTransCur`.`lang` = '{$lang}'
                        where `C`.`id` IN ({$pCompanyIdsArray})";

                $pOffersQuery = "
                    SELECT 	`co`.`id`,
                            `co`.`company_id`,
                            `co`.`code`,
                            `co`.`max_vouchers`,
                            `co`.`max_per_user`,
                            `co`.`count_voucher_codes`,
                            COALESCE(`cotrCurr`.`title`, `cotr`.`title`) AS `title`,
                            `img`.`filename`
                    FROM `company_offer` `co`
                    LEFT JOIN `company_offer_translation` `cotr` ON `co`.`id` = `cotr`.`id` AND `cotr`.`lang` = 'en'
                    LEFT JOIN `company_offer_translation` `cotrCurr` ON `co`.`id` = `cotrCurr`.`id` AND `cotrCurr`.`lang` = '{$lang}'
                    LEFT JOIN `image` `img` ON `co`.`image_id` = `img`.`id`
                    WHERE `co`.`is_active` = 1
                      AND `co`.`max_vouchers` > `co`.`count_voucher_codes`
                      AND `co`.`company_id` IN({$pCompanyIdsArray});
                ";
                break;
        }
    }
}

?>