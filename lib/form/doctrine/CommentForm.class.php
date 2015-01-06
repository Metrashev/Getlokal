<?php

/**
 * Comment form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommentForm extends BaseCommentForm
{
  public function configure()
  {
    $this->useFields(array('body'));
    
    $this->setWidgets(array(
    		'body'        => new sfWidgetFormTextarea(),
    ));
    
    $this->setValidators(array(
    		'body'        => new sfValidatorString(array('max_length' => 1000, 'required' => true)),
    ));
    
    $this->widgetSchema->setNameFormat('comment[%s]');
    
  }
}
