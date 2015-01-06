<?php
class placeNotificationTask extends sfBaseTask {
	protected function configure() {
		
		$this->addOptions ( array (
			new sfCommandOption ( 'application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend' ), 
			new sfCommandOption ( 'env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod' ), 
			new sfCommandOption ( 'connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')
		));
		
		$this->namespace = 'task';
		$this->name = 'sendCompanyMail';
		$this->briefDescription = 'send Company Mail';
		$this->detailedDescription = <<<EOF
The [sendCompanyMail|INFO] task rebuilds empty slugs.
Call it with: 
 
  [php symfony sendCompanyMail|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		date_default_timezone_set ( 'Europe/Sofia' );
		$databaseManager = new sfDatabaseManager ( $this->configuration );
		$connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
		$connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

		$today = date('Y-m-d');
		$query = Doctrine::getTable ( 'Company' )
		->createQuery ( 'c' )
		->addWhere ( 'c.created_by is not null' )
		->andWhere('c.created_at > ?', date ( 'Y-m-d', strtotime ('-8 days', strtotime($today))))
		->andWhere('c.created_at <= ?', date ( 'Y-m-d', strtotime ('-7 days', strtotime($today))))
		->andWhere ('c.status = 0 ');
//		->andWhere ( 'c.id = 401750' );

		$companies = $query->execute ();
		$count = 0;

		if (count ( $companies ) > 0) {
			foreach ( $companies as $company ) {
				$user_id = $company->get ( 'created_by' );
				$user = Doctrine::getTable ( 'SfGuardUser' )->findOneById ( $user_id );
				$to = $user->get ( 'email_address' );
				$vars = array ('company' => $company );
				$template = 'user_place_reminder';
				$context = sfContext::createInstance ( $this->configuration );
				$this->configuration->loadHelpers ( 'Partial' );

				$moduleName = 'mail';
				$culture_id = $company->get ( 'country_id' );
				if ($culture_id == getlokalPartner::GETLOKAL_BG) {
					$host = 'getlokal.com';
					$culture = 'bg';
					$from = array ('info@getlokal.com' => 'Getlokal' );
					$subject = $company->getCompanyTitleByCulture('bg');
				} elseif ($culture_id == getlokalPartner::GETLOKAL_RO) {
					$host = 'getlokal.ro';
					$culture = 'ro';
					$from = array ('romania@getlokal.com' => 'Getlokal' );
					$subject = $company->getCompanyTitleByCulture('ro');
				} elseif ($culture_id == getlokalPartner::GETLOKAL_MK) {
					$host = 'getlokal.mk';
					$culture = 'mk';
					$from = array ('macedonia@getlokal.com' => 'Getlokal' );
					$subject = $company->getCompanyTitleByCulture('mk');
				} elseif ($culture_id == getlokalPartner::GETLOKAL_RS) {
					$host = 'getlokal.rs';
					$culture = 'sr';
					$from = array ('serbia@getlokal.com' => 'Getlokal' );
					$subject = $company->getCompanyTitleByCulture('rs');
				} elseif ($culture_id == getlokalPartner::GETLOKAL_FI) {
					$host = 'getlokal.fi';
					$culture = 'fi';
					$from = array ('finland@getlokal.com' => 'Getlokal' );
					$subject = $company->getCompanyTitleByCulture('fi');
				}
				else{
					$host = 'getlokal.com';
					$culture = 'en';
					$from = array ('info@getlokal.com' => 'Getlokal' );
					$subject = $company->getCompanyTitleByCulture('en');
				}

				$routing = $context->getRouting ();
				$_options = $routing->getOptions ();
				$_options ['context'] ['prefix'] = ""; // "/frontend_dev.php" for dev; or "" for prod
				$_options ['context'] ['host'] = $host;
				$routing->initialize ( $this->dispatcher, $routing->getCache (), $_options );
				$context->getConfiguration ()->loadHelpers ( 'Partial' );
				$context->set ( 'routing', $routing );
				
				$template = mb_convert_case ( $culture, MB_CASE_UPPER ) . '/_' . $template;
				
				$actionName = $template;
				
				$class = sfConfig::get ( 'mod_' . strtolower ( $moduleName ) . '_partial_view_class', 'sf' ) . 'PartialView';
				$view = new $class ( sfContext::getInstance (), $moduleName, $actionName, '' );
				
				$view->setPartialVars ( true === sfConfig::get ( 'sf_escaping_strategy' ) ? sfOutputEscaper::unescape ( $vars ) : $vars );
				
				$bodyHtml = $view->render ();
				$bodyPlain = strip_tags ( $bodyHtml );
				
				$message = Swift_Message::newInstance ()->setSubject ( $subject )->setFrom ( $from )->setTo ( $to )->setBody ( $bodyPlain )->addPart ( $bodyHtml, 'text/html' );
				
				try {
					sfContext::getInstance ()->getMailer ()->send ( $message );
					$count++;
				} catch ( Exception $e ) {
					sfContext::getInstance ()->getUser ()->setFlash ( 'error', 'The email could not be sent.' );
				}
			}
			echo "Mail sent to {$count} users";
		}
		
		$cities = null;
		unset ( $cities );
		
		gc_collect_cycles ();
	}

}