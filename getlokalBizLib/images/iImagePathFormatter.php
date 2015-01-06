<?php
interface iImagePathFormatter
{
    /**
     * Each method has the following parameters.
     * @param $pFileName - the file name of the object's image red from DB
     * @param $pImageSize - it is one of the constants defined in the class imageSize
     * @param $pCurrUserId - the current User ID, because the URL might be dependent on it
     * @param $pLanguage - language, because the URL might be dependent on it
     * @return mixed - string which represents the URL of the image or the path to the image
     */
    public function getCompanyUrl($pFileName, $pImageSize, $pCurrUserId, $pLanguage);
    public function getProfileUrl($pFileName, $pImageSize, $pCurrUserId, $pLanguage);
    public function getOfferUrl($pFileName, $pImageSize, $pCurrUserId, $pLanguage);
}
?>