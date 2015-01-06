<?php 
class contactActions extends sfActions {
public function executeGetlokal(sfWebRequest $request){

		$this->form = new ContactForm();
		
		if($request->isMethod('POST')){
			$params = $request->getParameter($this->form->getName(), array());
			$this->form->bind($params);
			if($this->form->isValid()){
				$sSubject = 'Request through getlokal';
				$sFromEmail = mb_strtolower($this->form->getValue('email'));
				$sFromName = $this->form->getValue('name');
				$sFromPhone = $this->form->getValue('phone');
				$sFromText = $this->form->getValue('message');
				
				$sMessage = '<br /> Name: '. $sFromName;
				$sMessage .= '<br /> E-mail: '. $sFromEmail;
				$sMessage .= '<br /> Phone: '. $sFromPhone;
				$sMessage .= '<p>';
				$sMessage .= '<br /> '. $sFromText;

				$domain = sfContext::getInstance()->getRequest()->getHost();
				$domain_array = sfConfig::get('app_domain_slugs');
				$flag = false;
           
		        foreach($domain_array as $dom){
		            if(strstr($domain, $dom) !== false){
		                 $country_name = strtolower(sfConfig::get('app_countries_'.$dom));
		                 $to = $country_name.'@getlokal.com';
		                 $flag = true;
		                 break;
		            }
		       }

		       	if($flag === false && (strstr($domain, '.com') || strstr($domain, '.my'))){
		            $to = 'info@getlokal.com';
		        }

/*				$culture=$this->getUser()->getCulture();
				 if (strpos($domain, 'ro')):
                    $to='romania@getlokal.com';
                 elseif	(strpos($domain, 'bg')):
                     $to='info@getlokal.com';
                 elseif	(strpos($domain, 'mk')):
                     $to='macedonia@getlokal.com';
                 elseif	(strpos($domain, 'rs')):
                     $to='serbia@getlokal.com';
                 else:
                 	 $to='info@getlokal.com';
                 endif;
*/					
					$i18n = sfContext::getInstance ()->getI18N ();
						$message = Swift_Message::newInstance ()
						->setSubject ($i18n->__($sSubject, null,'mailsubject'))->setFrom ( $sFromEmail )
						->setTo ( $to )->setBody ( stripslashes ( $sMessage ) )
						->addPart ( $sMessage, 'text/html' );
						
						$this->getMailer ()->send ( $message );           				
				
				$this->getUser()->setFlash('notice', 'Your message was sent successfully.'); 
				$this->redirect('contact/getlokal');
			}
			
		}

		breadCrumb::getInstance()->removeRoot();
		breadCrumb::getInstance()->add('Contact Us');
		
		return sfView::SUCCESS;
	}
    public function executeGetlokaloffices(sfWebRequest $request){
       $i18n = sfContext::getInstance()->getI18N();
       $this->setTemplate('getlokaloffices');
       breadCrumb::getInstance()->removeRoot();
	   breadCrumb::getInstance()->add($i18n->__ ('Office Addresses', null, 'messages'));
    }
}