<?php

require_once dirname(__FILE__).'/../lib/classificationGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/classificationGeneratorHelper.class.php';

/**
 * classification actions.
 *
 * @package    getLokal
 * @subpackage classification
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class classificationActions extends autoClassificationActions
{

    public function preExecute()
    {
        sfConfig::set('view_no_google_maps', true);
        parent::preExecute();
    }

    public function executeAddSector($request) 
    {
        $number = intval ( $request->getParameter ( "num" ) );

        if ($classification = Doctrine::getTable('Classification')->find($request->getParameter('id'))) {
            $form = new backendClassificationForm ( $classification );

        } 
        else {
            $form = new backendClassificationForm ( null);

        }
        $form->addClassificationSector ( $number );

        return $this->renderPartial ( 'addsector', array ('form' => $form, 'num' => $number ) );
    }


    public function executeUpdateCount(sfWebRequest $request)
    {
        $this->classification = $this->getRoute()->getObject();

        $lang_array = array('bg','ro','mk','sr', 'fi', 'hu','pt','me','ru');
        foreach ($lang_array as $lang){
            $trans_id = $this->classification->Translation[$lang]->id;
            $country_id = getlokalPartner::getInstance($lang);
            $count_places  =  Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.CompanyClassification cc')
                ->addWhere('country_id = ? AND status = ? ', array($country_id, CompanyTable::VISIBLE))
                ->andWhere('cc.classification_id = ? ', $this->classification->getId())
                ->count();

            $q = Doctrine_Query::create()
                ->update('ClassificationTranslation')
                ->set('number_of_places', $count_places)
                ->where('id = ?', $this->classification->getId())
                ->andWhere('lang = ?', $lang)->execute();

         }
         $this->redirect('@classification');
    }
    public function executeBatchUpdate() 
    {
        $ids = Doctrine_Query::create()
                ->select('c.id')
                ->from('Classification c')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->orderBy('id')
                ->execute();
        $lang_array = array('bg','ro','mk','sr','fi', 'en' ,'ru', 'hu', 'pt','me');
        foreach ($lang_array as $lang)
        {
            $count_places =0;

            foreach($ids as $id){
                if($lang != 'en' && $lang != 'ru'){
                    $country_id = getlokalPartner::getInstance($lang);
                    $count_places  =  Doctrine::getTable('Company')
                        ->createQuery('c')
                        ->innerJoin('c.CompanyClassification cc')
                        ->addWhere('country_id = ? AND status = ? ', array($country_id, CompanyTable::VISIBLE))
                        ->andWhere('cc.classification_id = ? ', $id['id'])
                        ->count();

                }
                switch($lang){
                    case 'bg':
                    case 'ro':
                    case 'mk':
                    case 'sr':
                    case 'fi':
                    case 'hu':
                    case 'pt':
                        if($count_places == 0){
                            $q = Doctrine_Query::create()
                                ->update('ClassificationTranslation')
                                ->set(array('number_of_places'=>$count_places, 'is_active'=> 1))
                                ->where('id = ?', $id['id'])
                                ->andWhere('lang = ?', $lang)
                                ->execute();
                        }
                        else{
                            $q = Doctrine_Query::create()
                                ->update('ClassificationTranslation')
                                ->set(array('number_of_places'=>$count_places, 'is_active'=> 0))
                                ->where('id = ?', $id['id'])
                                ->andWhere('lang = ?', $lang)
                                ->execute();
                        }
                        break;

                    case 'en':
                    case 'ru':
                        $q = Doctrine_Query::create()
                            ->update('ClassificationTranslation')
                            ->set(array('number_of_places'=>$count_places, 'is_active'=> 0))
                            ->where('id = ?', $id['id'])
                            ->andWhere('lang = ?', $lang)
                            ->execute();
                        break;
                }
            }
        }
        $this->redirect('@classification');     
    }
}
