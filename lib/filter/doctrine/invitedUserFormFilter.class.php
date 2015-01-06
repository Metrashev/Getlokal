<?php

/**
 * invitedUser filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class invitedUserFormFilter extends BaseinvitedUserFormFilter
{
    public function configure()
    {
	  $this->widgetSchema ['email'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ('email', new sfValidatorPass ( array ('required' => false ) ) );

	  $this->widgetSchema ['facebook_uid'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ('facebook_uid', new sfValidatorPass ( array ('required' => false ) ) );

          $this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ('first_name', new sfValidatorPass ( array ('required' => false ) ) );

	  $this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ('last_name', new sfValidatorPass ( array ('required' => false ) ) );

          //$this->widgetSchema->setLabels(array('email' => 'Invited user e-mail', 'facebook_uid' => 'Invited user facebook'));
          
	  $this->widgetSchema ['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'City', 'method' => 'getLocation', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'lists', 'action' => 'getCitiesAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 1,
          max: 10,
          minChars:0
       }' ) );
	  $this->setValidator ( 'city_id', new sfValidatorPass ( array ('required' => false ) ) );
    }

    public function addFacebookUidColumnQuery($query, $field, $value) {
        if ($value ['text'] != null) {
            Doctrine::getTable('InvitedUser')->applyFacebookFilter($query, $value);
        }
    }

    public function addEmailColumnQuery($query, $field, $value) {
        if ($value ['text'] != null) {
            Doctrine::getTable('InvitedUser')->applyEmailFilter($query, $value);
        }
    }

    public function addFirstNameColumnQuery($query, $field, $value) {
        if ($value ['text'] != null) {
            Doctrine::getTable('InvitedUser')->applyFirstNameFilter($query, $value);
        }
    }

    public function addLastNameColumnQuery($query, $field, $value) {
        if ($value ['text'] != null) {
            Doctrine::getTable('InvitedUser')->applyLastNameFilter($query, $value);
        }
    }

    public function addCityIdColumnQuery($query, $field, $value) {
        if ($value ['text'] != null) {
            Doctrine::getTable('InvitedUser')->applyCityFilter($query, $value);
        }
    }
}
