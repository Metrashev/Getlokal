<?php
class defaultImageUrlFormatter implements iImagePathFormatter
{
    //TODO: Currently each method returns the file name only. It should return the URL regarding the size and the url
    //pattern  regarding the project needs

    public function getCompanyUrl($pFileName, $pImageSize, $pCurrUserId, $pLanguage)
    {
        return $pFileName;
    }

    public function getProfileUrl($pFileName, $pImageSize, $pCurrUserId, $pLanguage)
    {
        return $pFileName;
    }

    public function getOfferUrl($pFileName, $pImageSize, $pCurrUserId, $pLanguage)
    {
        return $pFileName;
    }
}
?>