<?php

/**
 * PilotVideo form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PilotVideoForm extends BasePilotVideoForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);
  }
}
