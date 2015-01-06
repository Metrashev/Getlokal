<?php
class ArtImageForm extends ArticleImageForm {
        
        public function configure() {
        parent::configure();
       
        /*
         * Use Fields
         */
        $this->useFields(array('filename','descrption','source','user_id'));
        /*
         * Widgets
         */ 
        $this->widgetSchema['filename']= new sfWidgetFormInputFile();
        $this->widgetSchema['descrption'] = new sfWidgetFormInputText();
        $this->widgetSchema['source'] = new sfWidgetFormInputText();
        $this->widgetSchema['user_id']=new sfWidgetFormInputHidden();
        /*
         * Validators
         */ 
        $max_size = 4*1024*1024;
        $this->setValidator('filename', new sfValidatorFile(array(
        	'max_size' => $max_size,
            'required' => false,
            'mime_types' => 'web_images', //array('image/png'),
            'path' => ZestCMSImages::getImagePath('article', 'original'),
        ),array("max_size"=>"Maximum upload size is 4MB.")));
        
        //$this->setValidator('descrption', new ArticlePhotoValidatorSchema(array('required' => false) ) );
        
        /*
         * Labels
         */
        $this->widgetSchema->setLabels(array(
            'filename' =>  'Image (recommended 600x278 pxls)',
        	'descrption' => 'Image Descrption',
        	'source' => 'Image Source'
        ));
        
        $this->validatorSchema->setOption ( 'allow_extra_fields', true );
        $this->validatorSchema->setOption ( 'filter_extra_fields', true );
        
        $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
    }
        
}