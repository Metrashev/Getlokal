<?php

/**
 * Review form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReviewImageForm extends BaseReviewForm {
	public function configure() {
		parent::configure ();
		$i18n = sfContext::getInstance ()->getI18N ();
		$this->useFields ( array ('rating', 'text' ) );
		
		$this->widgetSchema ['rating'] = new sfWidgetFormSelectRadio ( array ('choices' => array ('1' => '', '2' => '', '3' => '', '4' => '', '5' => '' ) ) );
		
		$this->widgetSchema->setLabel ( 'rating', $i18n->__ ( 'Rate', null, 'reviews' ) );
		
		$this->validatorSchema ['rating'] = new sfValidatorChoice ( array ('choices' => array (1, 2, 3, 4, 5 ), 'required' => false ), array ('required' => $i18n->__ ( 'Please rate this company', null, 'form' ), 'invalid' => $i18n->__ ( 'Please rate this company', null, 'form' ) ) );
		
		$this->widgetSchema ['text'] = new sfWidgetFormTextarea ( array (), array ('cols' => 45, 'rows' => 8 ) );
		
		$this->validatorSchema ['text'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'min_length' => 5, 'trim' => true ), array ('min_length' => $i18n->__ ( 'The review must contain at least %min_length% characters', null, 'errors' ) ) ), new sfValidatorBlacklist ( array ('case_sensitive' => false, 'required' => true, 'forbidden_values' => array ('shit', 'fuck', 'лайно', 'lajno', 'laino', 'govno', 'mother fucker', 'fucker', 'еба', 'ебати' ) ), array ('forbidden' => $i18n->__ ( 'The review contains forbidden words', null, 'errors' ) ) ) ), array ('required' => false ), array ('required' => $i18n->__ ( 'Type Review', null, 'errors' ) ) );
		$this->widgetSchema ['file'] = new sfWidgetFormInputFile ();
		$this->widgetSchema->setLabels ( array ('caption' => 'Caption', 'file' => 'Select a photo from your computer' ) );
		
		$this->validatorSchema ['file'] = new sfValidatorFile ( array ('required' => false, 'max_size' => 4 * 1024 * 1024, 'mime_type_guessers' => array (array (new sfValidatorFile (), 'guessFromFileBinary' ), array (new sfValidatorFile (), 'guessFromMimeContentType' ), array (new sfValidatorFile (), 'guessFromFileinfo' ) ), 'mime_types' => array ('image/bmp', #bmp
'image/vnd.wap.wbmp', #bmp
'image/x-bmp', #bmp
'image/x-ms-bmp', #bmp
'image/gif', #gif
'image/jpeg', #jpg
'image/pjpeg', #jpeg
'image/png', #png
'image/x-png' )#png
 ), array ('required' => 'The field is mandatory', 'max_size' => 'File size limit is 4MB.Please reduce file size before submitting again.', 'mime_types' => 'The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.', 'extension' => 'The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.' ) );
		//$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		// $this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
 
 $this->validatorSchema->setPostValidator ( new sfValidatorCallback ( array ('callback' => array ($this, 'postValidateMe' ) ) ) );

    }
public function processUploadedFile($field, $filename = null, $values = null) {
		return true;
	}
    
public function postValidateMe($validator, $values) {
		
		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
		$i18n = sfContext::getInstance ()->getI18N ();
		
		
		
		if ($values ["text"]=="" && $values ["file"]=="") {
			if ($values ["rating"]!="")
			{
				$error = new sfValidatorError ( $validator, $i18n->__ ( 'Type Review', null, 'errors' )); 
			}else {
			$error = new sfValidatorError ( $validator, 'Write a review or upload a picture' );
			}
			throw new sfValidatorErrorSchema ( $validator, array ('text' => $error ) );
		}
       if ($values ["text"]!="" && $values ["rating"]=="") {
			$error = new sfValidatorError ( $validator, $i18n->__ ( 'Please rate this company', null, 'form' ));
			throw new sfValidatorErrorSchema ( $validator, array ('text' => $error ) );
		}
		
		
		return $values;
	}
  }
