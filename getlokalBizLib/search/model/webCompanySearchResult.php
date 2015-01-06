<?php
require_once(__DIR__ .'./companyOfferSearchResult.php');

class webCompanySearchResult
{
    public $id;
    public $title;
    public $rank;
    public $reviewsCount;
    public $address;
    public $slug;
    public $picture;
    public $sectorId;
    public $classificationId;
    public $classificationName;
    public $classificationSlug;
    public $isPPP;
    public $latitude;
    public $longitude;
    public $citySlug;
    public $phone;
    public $pppReviewId;
    public $pppReviewText;
    public $pppReviewPicture;
    public $favorite;

    /**
     * @var = array of companyOfferSearchResult
     */
    public $offers;
}

?>