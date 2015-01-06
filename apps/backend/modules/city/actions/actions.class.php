<?php

require_once dirname(__FILE__).'/../lib/cityGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cityGeneratorHelper.class.php';

/**
 * city actions.
 *
 * @package    getLokal
 * @subpackage city
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cityActions extends autoCityActions
{
  public function executeGeocode(sfWebRequest $request) {

    //$ids = $request->getParameter ( 'ids' );
    $this->records = Doctrine_Query::create()
      ->from('City as ct')
      ->innerJoin('ct.County as cnt')
      ->innerJoin('cnt.Country as ctr')
      ->where('lat is null or lng is null or lat="" or lng="" ')
      ->orderBy('ct.id')
      ->limit(300)
      ->execute();
  }

  public function executeSavegeo(sfWebRequest $request) {
    $city =  Doctrine_Core::getTable('City')->findOneBy('id',$request->getParameter ( 'cityId' ));
    $city->setLat($request->getParameter ( 'lat' ));
    $city->setLng($request->getParameter ( 'lng' ));
    $city->save();

    $this->setTemplate('done');
  }

  public function executeAutocomplete(sfWebRequest $request)
  {
    $this->forward404Unless($term = $request->getParameter('term', false));
    $country_id = null;
    $exclude = array();

    $country_id = 1;
    if ($request->getParameter('country', false))
    {
      $country_id = $this->getUser()->getCountry()->getId();
    }
    $exclude = $request->getParameter('exclude', array());

    $this->getResponse()->setContent(json_encode(CityTable::getAutocompleteJSON(
      $term, $exclude, $country_id
    )));

    return sfView::NONE;
  }
}
