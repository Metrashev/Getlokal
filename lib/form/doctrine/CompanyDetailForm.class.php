<?php

/**
 * CompanyDetail form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyDetailForm extends BaseCompanyDetailForm {
	
	public function configure() {
		
		unset ( $this ['company_id'], $this ['created_at'], $this ['updated_at'], $this ['id'] );
                
		for($i = 0; $i < 1440; $i += 30) {
			$hours [$i] = sprintf ( '%02d:%02d', floor ( $i / 60 ), ($i % 60) );
		}
		
		foreach ( array ('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) as $day ) {
			$this->widgetSchema [$day . '_from'] = new sfWidgetFormChoice ( array ('choices' => $hours ) );
			$this->widgetSchema [$day . '_to'] = new sfWidgetFormChoice ( array ('choices' => $hours ) );
		}
		$this->widgetSchema->setLabels ( array ('mon_from' => 'Monday', 'tue_from' => 'Tuesday', 'wed_from' => 'Wednesday', 'thu_from' => 'Thursday', 'fri_from' => 'Friday', 'sat_from' => 'Saturday', 'sun_from' => 'Sunday', 'mon_to' => '', 'tue_to' => '', 'wed_to' => '', 'thu_to' => '', 'fri_fto' => '', 'sat_to' => '', 'sun_to' => '') );
		
                
                $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
                $current_culture = sfContext::getInstance()->getUser()->getCulture();
                
                //$this->embedI18n(array('en', $culture, $current_culture));
                
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
	public function doSave($con = null) {
		
		
		
		
		foreach ( array ('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) as $day ) {
			
			if (isset ( $this->values ['close_' . $day] )) {
				$this->values [$day . '_from'] = $this->values [$day . '_to'] = 1;
			} else {
				
				if (isset ( $this->values [$day . '_from'] ) && ! empty ( $this->values [$day . '_from'] )) {
					$this->values [$day . '_from'] = $this->CalculateTimeAsInteger ( $this->values [$day . '_from'] );
				}
				if (isset ( $this->values [$day . '_to'] ) && ! empty ( $this->values [$day . '_to'] )) {
					$this->values [$day . '_to'] = $this->CalculateTimeAsInteger ( $this->values [$day . '_to'] );
				}
			}
		}
	
	
		parent::doSave($con);
		
	}
	protected function CalculateTimeAsInteger($result) {
		
		if (is_array ( $result )) {
			if (! $this->array_empty ( $result )) {
				foreach ( $result as $key => $value ) {
					$values [] = $value;
				}
				$newvalue = $values [0] * 60 + $values [1];
			} else {
				$newvalue = null;
			}
		} else {
			$newvalue = $result;
		}
		return $newvalue;
	}
}
