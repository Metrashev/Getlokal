<?php

/**
 * CompanyDetail
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CompanyDetail extends BaseCompanyDetail
{




  public function postSave($event) {
		parent::postSave ( $event );
		$company = $this->getCompany();
        $company->save();

  }
  public function getHourFormat($day)
  {
    if(!in_array($day, array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'))) return '';

    if($this->get($day.'_from') == 1)
      return sfContext::getInstance()->getI18N()->__('Closed', null);

    $from = $this->get($day.'_from');
    $to   = $this->get($day.'_to');

    if(is_null($from) && is_null($to)) return 'N/A';

    return sprintf('%02d:%02d - %02d:%02d', floor($from / 60), ($from % 60), floor($to / 60), ($to % 60));
  }

public function getHourFormatCPage($day)
  {
    if(!in_array($day, array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'))) return '';


    $from = $this->get($day.'_from');
    $to   = $this->get($day.'_to');

    if(is_null($from) && is_null($to)) return false;
    if(($from == 1) && ($to == 1)) return 'closed';
    return sprintf('%02d:%02d   %02d:%02d', floor($from / 60), ($from % 60), floor($to / 60), ($to % 60));
  }

  public function getWorkingHours()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $from = $hours = array();
    $from = array('days' => array($i18n->__('Mon')), 'time' => $this->getHourFormat('mon'));
    foreach(array('tue', 'wed', 'thu', 'fri', 'sat', 'sun', 'end') as $day)
    {
      if($from['time'] == $this->getHourFormat($day))
      {
        $from['days'][] = $i18n->__(ucfirst($day));
      }
      else
      {
        $hours[] = array('day' => sizeof($from['days']) == 1? array_shift($from['days']): array_shift($from['days']). ' - '. array_pop($from['days']), 'time' => $from['time']);

        $from = array('days' => array($i18n->__(ucfirst($day))), 'time' => $this->getHourFormat($day));
      }
    }

    return $hours;
  }

  public function getDetailDescription($culture= null)
  {
    if (is_null ( $culture )) {
			$culture = sfContext::getInstance ()->getUser ()->getCulture ();
		}
		$detail_description = $this->getContent();
      return $detail_description;
  }
	public function save(Doctrine_Connection $conn = null) {
		if (! $this->isNew ()) {
			if (in_array ( $this->getCompanyId (), sfContext::getInstance()->getUser()->getAdminCompanies () )){

			$modified = $this->getModified ( true );

			if (isset ( $modified ['mon_from'] )
			or isset ( $modified ['mon_to'] )
			or isset ( $modified ['tue_from'] )
			or isset ( $modified ['tue_to'] )
			or isset ( $modified ['wed_from'] )
			or isset ( $modified ['wed_to'] )
			or isset ( $modified ['thu_from'] )
			or isset ( $modified ['thu_to'] )
			or isset ( $modified ['fri_from'] )
			or isset ( $modified ['fri_to'] )
			or isset ( $modified ['sat_from'] )
			or isset ( $modified ['sat_to'] )
			or isset ( $modified ['sun_from'] )
			or isset ( $modified ['sat_to'] )
			) {
				$activity = new ActivityPage ();
				$activity->setText ( $this->getCompany()->getCompanyTitle () );
				$activity->setModifiedField ( 'w_hours' );
				$activity->setPageId ( $this->getCompany()->getCompanyPage ()->getId () );
				$activity->setUserId ( sfContext::getInstance()->getUser()->getGuardUser()->getId() );
				if ($this->getCompany()->getImage ()) {
					$activity->setMediaId ( $this->getCompany()->getImageId () );
				}
				$activity->save ();
			}
                        /*
			if (isset ( $modified ['content'] )
			or isset ( $modified ['content_en'] ))
			{
				$activity = new ActivityPage ();
				$activity->setText ( $this->getCompany()->getCompanyTitle () );
				$activity->setModifiedField ( 'content' );
				$activity->setPageId ( $this->getCompany()->getCompanyPage ()->getId () );
				$activity->setUserId ( sfContext::getInstance()->getUser()->getGuardUser()->getId() );
				if ($this->getCompany()->getImage ()) {
					$activity->setMediaId ( $this->getCompany()->getImageId () );
				}
				$activity->save ();
			}
                         * 
                         */
		}
		}
		return parent::save ( $conn );
	}

}