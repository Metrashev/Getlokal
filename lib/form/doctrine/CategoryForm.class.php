<?php

/**
 * Category form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryForm extends BaseCategoryForm
{
  public function configure()
  {
  	$this->embedI18n(array('en', 'ro', 'bg', 'mk', 'sr', 'fi', 'ru', 'hu', 'pt','me'));

    $this->widgetSchema->moveField('me', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('pt', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('hu', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('ru', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('fi', sfWidgetFormSchema::FIRST);
  	$this->widgetSchema->moveField('sr', sfWidgetFormSchema::FIRST);
  	$this->widgetSchema->moveField('mk', sfWidgetFormSchema::FIRST);
  	$this->widgetSchema->moveField('ro', sfWidgetFormSchema::FIRST);
  	$this->widgetSchema->moveField('bg', sfWidgetFormSchema::FIRST);
  	$this->widgetSchema->moveField('en', sfWidgetFormSchema::FIRST);

  	unset(
  		$this['created_at'],
  		$this['updated_at'],
  		$this['root_id'],
  		$this['lft'],
  		$this['rgt'],
  		$this['level']
  	);
  }
}
