<?php

/**
 * Message form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BulkMessageForm extends MessageForm
{
 public function configure()
  {
    $this->useFields(array(      
      'body'
    ));
    
    $this->widgetSchema['to'] = new sfWidgetFormChoice(array('multiple' => true, 'expanded' =>true, 'choices' => $this->getRcptsNew(), 'renderer_options' => array('formatter' => array('BulkMessageForm', 'MyChoiseFormatter'))));

    $this->setValidator('to',
                          new sfValidatorDoctrineChoice(array('model'    => 'Page',
                                                            'column'   => 'id',
                                                            'multiple' => true,
                                                            'required' => true),
    array('required' => 'Please select followers')));
    $this->validatorSchema['body'] = new sfValidatorString(array('max_length' => 1000, 'required' => true), array('required'=>'The field is mandatory'));
  		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );	
  }
  
  private function getRcptsNew()
  {
  sfApplicationConfiguration::getActive()->loadHelpers(array('Url', 'Tag','Asset'));
  	  $followers = $followers_list = array();
	   $q = Doctrine::getTable ( 'FollowPage' )
       ->createQuery('fp')
       ->where('fp.page_id = ?', sfContext::getInstance()->getUser()->getPageAdminUser()->getPageId())
       ->andWhere('fp.internal_notification = ?', true);
		$followers = $q->execute();
		
		
		
		foreach ($followers as $follower)
		{
				$followers_list[$follower->getUserProfile()->getUserPage()->getId()]= $follower->getUserProfile()->getLink(1) .$follower->getUserProfile();

		}
		 return $followers_list;
  }


    public static function MyChoiseFormatter($widget, $inputs) {
        $result = '<ul class="checkbox_list overview">';

        foreach ($inputs as $input) {
            $result .= '<li><div>' . $input ['input'] . "</div>" . $input ['label']  . '</li>';
        }

        $result .= '</ul>';

        return $result;
    }
}
