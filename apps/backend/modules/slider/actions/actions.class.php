<?php

require_once dirname(__FILE__).'/../lib/sliderGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/sliderGeneratorHelper.class.php';

/**
 * slider actions.
 *
 * @package    getLokal
 * @subpackage slider
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sliderActions extends autoSliderActions
{

  public function preExecute()
  {
    // disable maps for this module
    sfConfig::set('view_no_google_maps', true);
    parent::preExecute();
  }

}
