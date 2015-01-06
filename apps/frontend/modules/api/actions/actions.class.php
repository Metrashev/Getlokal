<?php

/**
 * api actions.
 *
 * @package    getLokal
 * @subpackage api
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiActions extends sfActions {


	public function executeMailBg(sfWebRequest $request) {


		$query = Doctrine::getTable('mailBgCampaign')->
		createQuery('mbc')
		->innerJoin('mbc.Company c')
		->innerJoin('mbc.City ci')
		->addWhere('mbc.is_active = ?', true)
		->andWhere('c.status = ?', CompanyTable::VISIBLE)
		->addOrderBy('ci.is_default DESC');
		
		$this->objects = $query->execute();
		$this->companies =array();
		foreach ($this->objects  as $object)
		{
			$this->companies[$object->getCity()->getName()][] = $object->getCompany();

		}
		$this->setLayout(false);
		
	}
  
  public function executeAutocomplete123(sfWebRequest $request)
  {
    $con = Doctrine::getConnectionByTableName('search');
    
    $lat = $con->quote($request->getParameter('lat', 0));
    $lng = $con->quote($request->getParameter('lng', 0));
    
    $text = str_replace(array('_','-', '"', ','), '', $request->getParameter('name'));
 
    $ids = array(0);
    $con = mysqli_connect(sfConfig::get('app_search_host'), null, null, null, sfConfig::get('app_search_port'));
    
    $query_string = $this->_EscapeSphinxQL($text);

    $sql = "SELECT *, @weight * score as total_score, GEODIST({$lat},{$lng}, latitude, longitude) as dist
            FROM search
            WHERE MATCH('{$query_string}') AND country_id = 2 ORDER BY total_score";

    if($lat)
    {
      $sql .= " * (4 - dist)";
    }
    $sql .= " DESC LIMIT 5 OPTION field_weights=(title = 1, body = 0, review = 0, keywords = 0)";
    
    mysqli_query($con, "SET NAMES utf8");
    $results = mysqli_query($con, $sql) or die(mysqli_error($con));
    while($row = mysqli_fetch_assoc($results))
    {
      $ids[] = $row['id'];
    }
    
    if($request->getParameter('url'))
    {
      $query = Doctrine::getTable('Company')
                ->createQuery('c')
                ->where('c.website_url LIKE ?', '%'.$request->getParameter('url').'%');
                
      $ids = array(0);
      if($company = $query->fetchOne())
      {
        $ids[] = $company->getId();
      }
    }
    if($request->getParameter('id'))
    {
      $query = Doctrine::getTable('Company')
                ->createQuery('c')
                ->where('c.id = ?', $request->getParameter('id'));

      $ids = array(0);
      if($company = $query->fetchOne())
      {
        $ids[] = $company->getId();
      }
    }
    
    $query = Doctrine::getTable('Company')
          ->createQuery('c')
          ->innerJoin('c.City')
          ->whereIN('c.id', $ids)
          ->andWhere('c.status = ?', 0)
          ->orderBy('FIELD(c.id,'. implode(',', $ids). ')')
          ->limit(50);
    
    $companies = array();
    foreach($query->execute() as $company)
    {
      $companies[$company->id] = $company;
    }
    
    $return = array();
    foreach($companies as $company)
    {
      $return[] = array(
        'id'          => $company->getId(),
        'title'       => $company->getCompanyTitle(),
        'address'     => $company->getDisplayAddress(),
        'web_address' => url_for($company->getUri()),
        'phone'       => $company->getPhone(),
        'city'        => $company->getCity()->__toString(),
        'latitude'    => $company->getLocation()->getLatitude(),
        'longitude'   => $company->getLocation()->getLongitude(),
      );
    }

    $this->getResponse()->setContent(json_encode($return));
    
    return sfView::NONE;
  }
  
   private function _EscapeSphinxQL($string) {
    $from = array( '\\', '(',')','|','-','!','@','~','"','&', '/', '^', '$', '=', "'", "\x00", "\n", "\r", "\x1a");
    $to = array('\\\\', '\\\(','\\\)','\\\|','\\\-','\\\!','\\\@','\\\~','\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=', "\\'", "\\x00", "\\n", "\\r", "\\x1a");

    return str_replace($from, $to, $string);
  }
}