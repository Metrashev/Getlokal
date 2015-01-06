<?php
class SearchCompanyForm extends BaseForm
{
public function configure()
  {
  	
  		$this->widgetSchema['mycompany']=  new sfWidgetFormInputText();
  	 	$partner= getlokalPartner::getInstance();
  	 	if ($partner == getlokalPartner::GETLOKAL_BG OR $partner == getlokalPartner::GETLOKAL_RS){
  		$this->widgetSchema->setLabel ( 'mycompany', 'Company Name or Bulstat' );
  	 	}elseif ($partner == getlokalPartner::GETLOKAL_RO)
  	 	{
  	 		$this->widgetSchema->setLabel ( 'mycompany', 'Company Name or CUI' );
  	 		
  	 	}
      elseif ($partner == getlokalPartner::GETLOKAL_MK)
  	 	{
  	 		$this->widgetSchema->setLabel ( 'mycompany', 'Company Name or Registration number' );
  	 		
  	 	}
  		$this->setValidator('mycompany'
			, new sfValidatorString(
				array (
					'required' => true
					, 'min_length' => 3
					, 'max_length' => 255 
				)
				, array(
					'required' => 'The field is mandatory'
					, 'min_length' => 'The field must contain at least %min_length% characters'
					, 'max_length' =>'This field cannot contain more than %max_length% characters'
				)
			)
		);
		 $this->widgetSchema->setNameFormat('search_company[%s]');
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
}
?>