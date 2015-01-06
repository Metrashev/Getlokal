<?php

/**
 * Article form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArticleForm extends BaseArticleForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();
  	$i18n = sfContext::getInstance()->getI18N();
  	unset(
  			$this['id'],
  			$this['created_at'],
  			$this['updated_at']
  			//$this['user_id']
  	);
  if (!$this->isNew()){
  	$categories = Doctrine::getTable('CategoryArticle')
  	->createQuery('c')
  	->leftJoin('c.CategoryArticleCountry cac' )
  	->where('c.status = "approved"')
  	->addWhere( 'country_id = ?', getlokalPartner::getInstanceDomain());
  	
  }
  
  	$this->widgetSchema['location_id']=new sfWidgetFormDoctrineJQueryAutocompleter(array(
  			'model' => 'City',
  			'method' =>'getLocation',
  			'url' => sfContext::getInstance()->getController()->genUrl ( array('module' => 'company', 'action' => 'autocompleteCity') ),
  			'config' => ' {
        scrollHeight: 250,
        autoFill: false,
        cacheLength: 1,
        delay: 1,
        max: 11,
        minChars:0
      }'
  	));
  	
  	/*$this->setValidators(array(
  			'title'    => new sfValidatorString(array('max_length' => 255, 'required' => true)),
  			'content'  => new sfValidatorString(array('max_length' => 255, 'required' => true)),
  			)
  		);*/
    $authors = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
        ->innerJoin('u.sfGuardUserPermission up')
        ->select('u.id', 'u.name')
        ->innerJoin('up.Permission p')
        ->where('p.name=?', 'article_writer')
        ->orderBy('u.first_name ASC')
        ->execute();
    $author_choices = array('' => '');
    foreach ($authors as $u) {
        $author_choices[$u->getId()] = $u->getName();
    }
    if (sfContext::getInstance()->getUser()->hasCredential('article_editor') && !$this->isNew()) {
	    $this->widgetSchema['user_id'] = new sfWidgetFormChoice(array(
            'choices' => $author_choices,
            'label' => 'Author',
        ));        
    } else {
        $this->widgetSchema['user_id']=new sfWidgetFormInputHidden();
    }

    $this->widgetSchema['publish_on'] = new sfWidgetFormI18nDateTime(array(
        'default' => date('Y-m-d H:i:s'),
        'culture' => sfContext::getInstance()->getUser()->getCulture()
    ));

    $this->widgetSchema['place_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'CompanyPage', 'multiple' => true));
	$this->widgetSchema['list_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'CompanyPage', 'multiple' => true));
	$this->widgetSchema['event_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'CompanyPage', 'multiple' => true));
	$this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices' => array('approved' => 'Approved', 'publish_on' => 'Scheduled publish', 'pending' => 'Pending', 'rejected' => 'Rejected')));
	if (!$this->isNew()){
		$this->widgetSchema['category_id']  = new sfWidgetFormDoctrineChoice(array('model' => 'CategoryArticle', 'add_empty' => false, 'multiple' => true, 'query'=> $categories));
	}

	$this->validatorSchema['location_id'] = new sfValidatorInteger(array('required' => false), array('required'=>'The field is mandatory'));
	$this->validatorSchema['place_id']	= new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CompanyPage', 'multiple' => true), array('required'=>'The field is mandatory'));
	$this->validatorSchema['list_id']	= new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'List', 'multiple' => true), array('required'=>'The field is mandatory'));
	$this->validatorSchema['event_id']	= new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Event', 'multiple' => true), array('required'=>'The field is mandatory'));	
	$this->validatorSchema['status'] = new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'publish_on', 2 => 'pending', 3 => 'rejected'), 'required' => false));
	if (!$this->isNew()){
		$this->validatorSchema['category_id']  = new sfValidatorDoctrineChoice(array('model' => 'CategoryArticle', 'required' => false));
	}
	$this->validatorSchema->setOption ( 'allow_extra_fields', true );
	$this->validatorSchema->setOption ( 'filter_extra_fields', true );
	//$this->setDefault('location_id', sfContext::getInstance()->getUser()->getCity()->getId());

	$culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
  	$this->embedI18n(array('en', $culture));
  	
  	$form = new ArticleImageCollectionForm(null, array(
  			'object' => $this->getObject(),
  			'size'	=> 6,
  	));
  	
  	$this->embedForm('newImages', $form);
  	
  	
  	$this->widgetSchema->setNameFormat('article[%s]');
  	$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
  
  
}
