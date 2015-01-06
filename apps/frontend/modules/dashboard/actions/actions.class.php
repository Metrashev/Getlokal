<?php

/**
 * company actions.
 *
 * @package    getLokal
 * @subpackage company
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions
{
public function executeIndex(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getGuardUser();
  	$this->profile = $this->user->getUserProfile();
    $this->user_page = $this->profile->getUserPage();
    $this->activities = array();    
    $this->page =  $request->getParameter ( 'page', 1 );

    $query = Doctrine::getTable('Activity')
                ->createQuery('a')  
                ->leftJoin('a.UserProfile')              
                ->leftJoin('a.Image')
                ->leftJoin('a.Page')
                ->where('user_id !='.$this->user->getId());

                
  $sql= 'select distinct activity.id from activity 
  where 
  (page_id  IN (select page_id from follow_page where user_id='.$this->user->getId ().' and 
 follow_page.created_at < activity.created_at and
 follow_page.newsfeed = true)
 or user_id IN (select foreign_id from page inner join follow_page on follow_page.page_id = page.id where follow_page.user_id='.$this->user->getId ().' and 
 follow_page.created_at < activity.created_at and
 follow_page.newsfeed = true))
 and activity.user_id != '.$this->user->getId (); 
     
   $con = Doctrine::getConnectionByTableName('Activity');       
   $result = $con->execute($sql);
   $ids=array();
   while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
      $ids[] = $row['id'];
    }
    if (!empty($ids)){
      $query = Doctrine::getTable('Activity')
                ->createQuery('a')  
                ->leftJoin('a.UserProfile')              
                ->leftJoin('a.Image')
                ->leftJoin('a.Page')
                 ->whereIN('a.id', $ids)
                 ->orderBy('a.created_at DESC');
        
  /*
    $q3 = $query->createSubquery ()
    ->select ( 'upa.foreign_id' )
    ->from ( 'UserPage upa' )
    ->innerJoin('upa.FollowPage fp')
    
    ->andWhere ( 'fp.user_id = ' . $this->user->getId ())
    ->andWhere ( 'fp.newsfeed = true');

   
    $q4 = $query->createSubquery ()
    ->select ( 'fp1.page_id' )->from ('FollowPage fp1')
    ->andWhere ( 'fp1.user_id = ' . $this->user->getId () .' or '. 'fp1.page_id = '. $this->page->getId())
     ->andWhere ( 'fp1.newsfeed = true');
    
    $query->andWhere ( 'a.user_id  IN (' . $q3->getDql () . ')' .' or a.page_id  IN (' . $q4->getDql () . ')')
    ->orderBy('a.created_at DESC');
    */
    
      $this->pager = new sfDoctrinePager ( 'Activity', 5 );
      $this->pager->setPage ( $this->page );
      $this->pager->setQuery ( $query);
      $this->pager->init ();     
      return $this->renderPartial('home/feed', array( 'pager' => $this->pager, 'page' => $this->page ));

}
  
   	breadCrumb::getInstance ()->removeRoot ();
  }
}