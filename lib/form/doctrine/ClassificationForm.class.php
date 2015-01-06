<?php

/**
 * Classification form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ClassificationForm extends BaseClassificationForm
{
  public function configure()
  {
    $this->useFields(array('status'));
    $this->embedI18n(array('bg', 'en', 'ro', 'mk', 'fi'));
  }
}
