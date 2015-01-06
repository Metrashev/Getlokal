<?php

/**
 * Sector filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SectorFormFilter extends BaseSectorFormFilter
{  
     public function configure()
    {    
        $this->setWidget ( 'rank', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
	$this->setValidator ( 'rank', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
          
    }

    
    public function addRankColumnQuery($query, $field, $value)  
    {
            if ($value ['text'] != null) {
                    Doctrine::getTable ( 'Sector' )->applyRankFilter ( $query, $value );
            }
    }

}
