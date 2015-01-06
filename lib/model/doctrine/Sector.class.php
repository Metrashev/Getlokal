<?php

/**
 * Sector
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Sector extends BaseSector
{
  public function preSave($event)
  {
    parent::postSave ( $event );
    
    $sectors = $this->getTranslation();
    
    foreach ($sectors as $sec) {
        
        $sector =  Doctrine::getTable('SectorSlugLog')
        ->createQuery('ssl')
        ->where('ssl.old_slug=? and ssl.lang=? and ssl.sector_id=?', array($sec->_get('slug'), $sec->_get('lang'),$sec->_get('id') ) )
        ->fetchOne();
      
        if (!$sector && $sec->_get('slug'))
        {
          $log = new SectorSlugLog();
          $log->setSectorId($sec->_get('id'));
          $log->setLang($sec->_get('lang'));
          $log->setOldSlug($sec->_get('slug'));
          $log->save();
        }
    }
  }

  public static function checkSlug($slug, $lang, $id) 
  {
    $sector = Doctrine::getTable('Sector')
    ->createQuery('s')
    ->innerJoin('s.Translation st')
    ->innerJoin('s.SectorSlugLog asl')
    //->where('asl.old_slug=? and asl.lang=? and asl.sector_id!=?', array($slug, $lang, $id))
    //->orWhere('st.slug=? and st.lang=? and st.id!=?', array($slug, $lang, $id) )
    ->where('asl.old_slug=? and asl.sector_id!=?', array($slug, $id))
    ->orWhere('st.slug=? and st.id!=?', array($slug, $id) )
    ->fetchOne();

    return ($sector) ? true : false;
    
    /*if ($sector)
    {
      return true;
    }
    
    return false;*/
}


public function getSlugByCulture($culture)
{
    if ($this->Translation[$culture]->_get('slug', $culture))
      return $this->Translation[$culture]->_get('slug', $culture);
    else return false;
}




}