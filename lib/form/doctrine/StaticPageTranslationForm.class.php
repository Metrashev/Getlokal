<?php

/**
 * StaticPageTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StaticPageTranslationForm extends BaseStaticPageTranslationForm
{
  public function configure()
  {
  		$this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCECustom ( array ('width' => 580, 'height' => 300, 'theme' => 'advanced' ), array ('class' => 'tinyMCE' ) ) ;
 	
  }
}
