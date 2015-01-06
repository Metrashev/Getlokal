<?php

/**
 * CoverImage form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CoverImageForm extends BaseCoverImageForm
{
public function configure()
  {
  	$this->useFields(array('caption','filename'));
   
    $this->widgetSchema['filename'] = new sfWidgetFormInputFile();
    $this->widgetSchema->setLabels ( array (
      'caption' => 'Caption',
      'filename'=>'Select a photo from your computer'
 ));

    $this->validatorSchema['filename'] = new sfValidatorFile(
      array(
       'path' => sfConfig::get('sf_upload_dir'),
       'validated_file_class' => 'sfResizedFileCompany',
        'required' => true,
        'max_size' => 4*1024*1024,
        'mime_type_guessers' => array(
          array(new sfValidatorFile(), 'guessFromFileBinary'),
          array(new sfValidatorFile(), 'guessFromMimeContentType'),
          array(new sfValidatorFile(), 'guessFromFileinfo')
        ),
        'mime_types' => array(
//          'image/bmp',                      #bmp
//          'image/vnd.wap.wbmp',             #bmp
//          'image/x-bmp',                    #bmp
//          'image/x-ms-bmp',                 #bmp
          'image/gif',                      #gif
          'image/jpeg',                     #jpg
          'image/pjpeg',                    #jpeg
          'image/png',                      #png
          'image/x-png',                    #png
        ),
      ),
      array(
        'required'    => 'The field is mandatory',
        'max_size'    => 'File size limit is 4MB.Please reduce file size before submitting again.',
        'mime_types'  => 'The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.',
        'extension'   => 'The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.',
      )
    );
    
    $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
  


}
