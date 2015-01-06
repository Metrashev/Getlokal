<?php

/**
 * ClassificationTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ClassificationTranslationForm extends BaseClassificationTranslationForm
{

  public function configure()
  {
    unset($this['number_of_places'], $this['old_slug']);

    $this->widgetSchema->setLabel('is_active', 'NOT Active?');

    $this->validatorSchema['short_title'] = new sfValidatorString(array(
        'max_length' => 255, 
        'required' => false,
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(    
        new sfValidatorDoctrineUnique(array(
            'model' => 'ClassificationTranslation',
            'column' => array('slug', 'lang'),
        ), array(
            'invalid' => 'A classification with the same slug and language already exists.'
        )),
        new sfValidatorCallback(array(
            'callback' => array($this, 'postValidation')
        ))
    )));

    $this->setWidget('description', new sfWidgetFormTextareaTinyMCECustom());

    $this->widgetSchema['title']->setOption('label', 'Classification name');
    $this->widgetSchema['page_title']->setOption('label', 'Page & meta title');
  }

  public function postValidation($validator, $values, $arguments) 
  {
    // check for old slugs on slug log
    $query = ClassificationSlugLogTable::getInstance()->createQuery('csl')
        ->where('csl.old_slug = ?', $values['slug'])
        ->andWhere('csl.lang = ?', $values['lang']);
    
    $translation = $this->getObject();
    if ($translation->exists()) {
        $query->andWhere('csl.classification_id != ?', $translation->get('id'));
    }

    if ($query->count() > 0) {
        throw new sfValidatorErrorSchema($validator, array(
            'slug' => new sfValidatorError(
                $validator, 
                'A classification with the same old slug and language already exists.'
            )
        ));
    }

    return $values;
  }

}
