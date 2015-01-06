<?php
class listComponents extends sfComponents
{
    public function executePlaces(sfWebRequest $request)
    {
		$this->culture = $this->getUser ()->getCulture ();
        $list = $this->list;
       	//print_r($item); exit();
        
        $query = Doctrine_Query::create()
          //->select('lp.*,cp.*,c.*,ct.*,cl.id as cl_id, cl.latitude as lat, cl.longitude as lon')
          ->from('ListPage lp')
          ->innerJoin('lp.CompanyPage cp')
          ->innerJoin('cp.Company c')
          ->innerJoin('c.City ct')
          ->innerJoin('c.CompanyLocation ccl')
          ->innerJoin('c.Location cl')
	      ->innerJoin('c.Classification ca')
	      ->innerJoin('c.Sector s')
	      ->innerJoin('s.Translation')
	      ->innerJoin('ca.Translation')
	      //->innerJoin('ct.County co')
          ->where('lp.list_id = ?', $list->getId() )
          ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
          ->orderBy('lp.rank ASC');
        
        
        $this->places = $query->execute();
    }
}



