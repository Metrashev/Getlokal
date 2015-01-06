<?php
class companyComponents extends sfComponents
{
    public function executePppVote(sfWebRequest $request)
    {
    	$this->place_vote = Doctrine::getTable('PlaceFeature')
    	->createQuery('pf')
    	->select('sum(pf.voted_yes) AS vot_yes, sum(pf.voted_no) AS vot_no')
    	->where('pf.page_id = ?', $this->company->getCompanyPage()->getId())
    	//->orderBy('pf.voted_yes DESC')
    	->execute();
    	
    }
    
    public function executeVote(sfWebRequest $request)
    {
        $this->futures = Doctrine::getTable('Feature')
                        ->createQuery('f')
                        ->select('f.*,ft.name as name, pf.voted_yes AS vot_yes, pf.voted_no AS vot_no ')
                        ->innerJoin('f.Translation as ft WITH ft.lang=?',$this->getUser()->getCulture())
                        ->innerJoin('f.SectorFeature sf ')
                        ->innerJoin('sf.Sector s ')
                        ->innerJoin('s.ClassificationSector cs WITH cs.classification_id = ?', $this->company->getClassification()->getId())
                        // ->innerJoin('cs.Classification c')
                        // ->innerJoin('c.CompanyClassification cc WITH cc.company_id = ?', $this->company->getId() )
                        ->leftJoin('f.PlaceFeature pf WITH pf.feature_id=f.id and pf.page_id = ? ', $this->company->getCompanyPage()->getId() )
                        // ->innerJoin('pf.Page p')
                        //->where('pf.page_id = ?', $this->company->getCompanyPage()->getId())
                        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                        ->orderBy('pf.voted_yes DESC')
                        ->execute();

        $this->pageId=$this->company->getCompanyPage()->getId();
    }
    
    public function executeCompanyReviews(sfWebRequest $request){
    	
    }
 
}



