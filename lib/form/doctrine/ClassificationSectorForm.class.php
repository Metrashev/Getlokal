<?php

/**
 * ClassificationSector form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ClassificationSectorForm extends BaseClassificationSectorForm
{
  public function configure()
  {
  	unset($this['classification_id'], $this['id']);
  	
  }
}
