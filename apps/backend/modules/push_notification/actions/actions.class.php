<?php

class push_notificationActions extends sfActions {
	/*
	 * 
	 */
	public function executeIndex(sfWebRequest $request) {
	  if (in_array($this->getUser()->getId(),array(4216, 89984, 97746)) )	{
		$choices = $this->_getFormChoice();
		$app_ver_choices = $choices['version'];
		$locale_choices = $choices['locale'];
		$this->no_form = false;
		
		$this->form = new MobileDeviceForm(array(), array('ver_choices' => $app_ver_choices, 'locale_choices' => $locale_choices));

		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ($this->form->getName());
			$this->form->bind($params);
			
			if ($this->form->isValid ()) {
				$this->no_form = true;
				list($message, $this->iOS, $this->android, $country_id, $country_gps, $city_id, $app_version, $locale) = $this->_getFilterParameters($params);
				
				$this->iOS_result = false;
				$this->android_result = false;
				
				if ($this->iOS) {
					$query_iOS = $this->_getIosQuery($country_id, $country_gps, $city_id, $app_version, $locale);
					$iOS_tokens = $query_iOS->fetchArray();
					
					if ($iOS_tokens && count($iOS_tokens) > 0) {
						$this->iOS_result = $this->_pushIOS($iOS_tokens, $message);
					}
				}
				
				if ($this->android) {
					$query_android = $this->_getAndroidQuery($country_id, $country_gps, $city_id, $app_version, $locale);
					$android_tokens = $query_android->fetchArray();
					
					if ($android_tokens && count($android_tokens) > 0) {
						$this->android_result = $this->_pushAndroid($android_tokens, $message);
					}
				}
				//var_dump($message, $iOS, $android, $country_id, $country_gps, $city_id, $app_version, $locale);exit;
				//Mobile Notification log
				$log = $this->_getLog($this->iOS, $this->android, $country_id, $country_gps, $city_id, $app_version, $locale, $this->iOS_result, $this->android_result);
												
				$push_log = new MobileNotifications();
				
				$push_log->setMessageText($message);
				$push_log->setDeviceOs($log['device_os']);
				$push_log->setAppVersion($log['app_version']);
				
				$push_log->setCountryId($log['country_id']);
				$push_log->setCityId($log['city_id']);
				$push_log->setCountryGps($log['country_gps']);
				$push_log->setLocale($log['locale']);
				
				if ($this->iOS && $this->iOS_result) {
					$push_log->setCountIos($log['count_ios']);
					$push_log->setSuccededIos($log['succeded_ios']);
					$push_log->setFailedIos($log['failed_ios']);
					$push_log->setDeletedIos($log['deleted_ios']);
				}
				
				if ($this->android && $this->android_result) {
					$push_log->setCountAndroid($log['count_android']);
					$push_log->setSuccededAndroid($log['succeded_android']);
					$push_log->setFailedAndroid($log['failed_android']);
					$push_log->setDeletedAndroid($log['deleted_android']);
				}
				
				$push_log->setSendFrom($this->getUser()->getId());
				
				$push_log->save();
			}
		}
	  }
	}
	
	private function _getLog($iOS, $android, $country_id, $country_gps, $city_id, $app_version, $locale, $iOS_result, $android_result) {
		$log = array();
		
		if ($iOS && $android) {
			$log['device_os'] = NULL;
		}
		elseif ($iOS) {
			$log['device_os'] = 'iOS';
		}
		else {
			$log['device_os'] = 'Android';
		}
		
		if (!$app_version) {
			$log['app_version'] = NULL;
		}
		else {
			$log['app_version'] = $app_version;
		}
		
		if (!$country_id) {
			$log['country_id'] = NULL;
		}
		else {
			$log['country_id'] = $country_id;
		}
		
		if (!$city_id) {
			$log['city_id'] = NULL;
		}
		else {
			$log['city_id'] = $city_id;
		}
		
		if (!$country_gps) {
			$log['country_gps'] = NULL;
		}
		else {
			$log['country_gps'] = $country_gps;
		}
		
		if (!$locale) {
			$log['locale'] = NULL;
		}
		else {
			$log['locale'] = $locale;
		}
		
		if ($iOS_result) {
			$log['count_ios'] = $iOS_result['all'];
			$log['succeded_ios'] = $iOS_result['success'];
			$log['failed_ios'] = $iOS_result['failure'];
			$log['deleted_ios'] = $iOS_result['deleted'];
		}
		
		if ($android_result) {
			$log['count_android'] = $android_result['all'];
			$log['succeded_android'] = $android_result['success'];
			$log['failed_android'] = $android_result['failure'];
			$log['deleted_android'] = $android_result['deleted'];
		}
		
		return $log;
	}
	
	private function _pushIOS($iOS_tokens, $message) {
		$all_tokens = count($iOS_tokens);
		$success_tokens = 0;
		$failed_tokens = 0;
		$deleted_tokens = 0;
		
		$passphrase = '1234';
		
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', sfConfig::get("sf_config_dir").DIRECTORY_SEPARATOR .'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		
			
		// Create the payload body
		$body['aps'] = array(
				'badge' => +1,
				'alert' => $message,
				'sound' => 'NOT2.aif'
		);
			
		$payload = json_encode($body);
		//$i = 0;
		$fp = null;
		
		foreach ($iOS_tokens as $token) {
			if (!isset($fp)) {
				$fp = stream_socket_client('ssl://gateway.push.apple.com:2195',
						$err,
						$errstr,
						60,
						STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,
						$ctx);
			}
			
			$deviceToken = $token['device_token'];
			// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
			$nPayloadLength	= strlen($payload);
			// Send it to the server
			$sRet  = pack('CNNnH*', 1, $token['id'], 0, 32, $deviceToken);
			$sRet .= pack('n', $nPayloadLength);
			$sRet .= $payload;
			//$i++;
			$msg_len = strlen($sRet);
			$result = (int)@fwrite($fp, $sRet);
			
			//$sErrorResponse = null;
			
			$tv_sec = 1;
			$tv_usec = null; // Timeout. 1 million micro seconds = 1 second
			$r = array($fp); $we = null; // Temporaries. "Only variables can be passed as reference."
			$numChanged = stream_select($r, $we, $we, $tv_sec, $tv_usec);
			
			if(false === $numChanged) {
				//var_dump("Failed selecting stream to read.");
			}
			elseif ($numChanged > 0) {
				$command = ord(fread($fp, 1));
				$status = ord(fread($fp, 1));
				$identifier = implode('', unpack("N", fread($fp, 4)));
				$statusDesc = array(
						0 => 'No errors encountered',
						1 => 'Processing error',
						2 => 'Missing device token',
						3 => 'Missing topic',
						4 => 'Missing payload',
						5 => 'Invalid token size',
						6 => 'Invalid topic size',
						7 => 'Invalid payload size',
						8 => 'Invalid token',
						255 => 'None (unknown)',
				);
							
				if($status > 0) {
					if ($device = Doctrine::getTable('MobileDevice')->findOneById($token['id'])) {
						$device->delete();
						$deleted_tokens++;
					}

					$failed_tokens++;
					//$desc = isset($statusDesc[$status])?$statusDesc[$status]: 'Unknown';
					//var_dump('*'.$identifier.'  -> '.$desc);
					fclose($fp);
					unset($fp);
				}
			}
			
			
			
			if (!$result)
				$failed_tokens++;
				//echo 'Message not delivered' . PHP_EOL;
			else {
				$success_tokens++;
				//echo 'Message successfully delivered: '.$message . PHP_EOL;
			}
		}
		
		// Close the connection to the server
		fclose($fp);
		
		$fp = stream_socket_client('ssl://feedback.push.apple.com:2196', 
				$error,
				$errorString, 
				100, 
				(STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT), 
				$ctx);
		
		if(!$fp) var_dump("Feedback: Failed to connect to device: {$error} {$errorString}.");
		
		while ($devcon = fread($fp, 38)){
			$arr = unpack("H*", $devcon);
			$rawhex = trim(implode("", $arr));
			$feed_token = substr($rawhex, 12, 64);
			if(!empty($token)){
				if ($device = Doctrine::getTable('MobileDevice')->findOneByDeviceToken($feed_token)) {
						$device->setIsActive(0);
						$device->save();
					}
					
				//var_dump("Unregistering Device Token: {$feed_token}.");
			}
		}
		
		fclose($fp);
		
		return array('all' => $all_tokens, 'success' => $success_tokens, 'failure' => $failed_tokens, 'deleted' => $deleted_tokens);
	}
	
	private function _pushAndroid($android_tokens, $message) {
		$api_access_key = 'AIzaSyDGo1fLT3dUhXSOsRZOyUhgOstmEAB5B0I';
		$max_devices = (1000 - 1);
		
		$all_tokens = count($android_tokens);
		$success_tokens = 0;
		$failed_tokens = 0;
		$deleted_tokens = 0;
		
		$errors_android = array(
			'InvalidRegistration' => 'InvalidRegistration',
			'NotRegistered' => 'NotRegistered'
		);
		
		$i = 0; $j = 0;
		
		foreach ($android_tokens as $token) {
			
			
			$registrationIds[$j]['token'][] = $token['device_token'];
			$registrationIds[$j]['id'][] = $token['id'];
			
			$i++;
			if ($i % $max_devices == 0) {
				$j++;
			}
		}
		
		$msg = array
		(
				'title'		=> 'Getlokal',
				'message' 	=> $message
		);
			
		for ($i = 0; $i <= $j; $i++) {
			$fields = array
			(
					'registration_ids' 	=> $registrationIds[$i]['token'],
					'data'			=> $msg
			);
				
			$headers = array
			(
					'Authorization: key=' . $api_access_key,
					'Content-Type: application/json'
			);
				
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch );
			curl_close( $ch );
				
			$result = json_decode($result);
			
			$success_tokens += $result->success;
			$failed_tokens += $result->failure;
			
			foreach ($result->results as $index => $res) {
				if (isset($res->error) && isset($errors_android[$res->error])) {
					$failed[] = $registrationIds[$i]['id'][$index];
				}
			}
		}
		
		if (isset($failed) && $failed) {
			$android_tokens_failed = Doctrine_Query::create()
										->delete('MobileDevice')
										->whereIn('id', $failed)
										->execute();
			$deleted_tokens = count($failed);
		}
		
		return array('all' => $all_tokens, 'success' => $success_tokens, 'failure' => $failed_tokens, 'deleted' => $deleted_tokens);
	}
	
	private function _getIosQuery($country_id, $country_gps, $city_id, $app_version, $locale) {
		$query_ios = Doctrine_Query::create()
					->select('md.device_token')
					->from('MobileDevice md')
					->where('md.device_os LIKE ? AND md.is_active != ?', array('%iOS%', 0));
		
		if ($country_id) {
			$query_ios->andWhere('md.country_id = ?', $country_id);
		}
		
		if ($country_gps) {
			$query_ios->andWhere('md.country_gps = ?', $country_gps);
		}
		
		if ($city_id) {
			$query_ios->andWhere('md.city_id = ?', $city_id);
		}
		
		if ($app_version) {
			$query_ios->andWhere('md.app_version = ?', $app_version);
		}
		
		if ($locale) {
			$query_ios->andWhere('md.locale = ?', $locale);
		}
		
		return $query_ios;
	}
	
	private function _getAndroidQuery($country_id, $country_gps, $city_id, $app_version, $locale) {
		$query_android = Doctrine_Query::create()
					->select('md.device_token')
					->from('MobileDevice md')
					->where('md.device_os LIKE ? AND md.is_active != ?', array('%Android%', 0));
	
		if ($country_id) {
			$query_android->andWhere('md.country_id = ?', $country_id);
		}
	
		if ($country_gps) {
			$query_android->andWhere('md.country_gps = ?', $country_gps);
		}
	
		if ($city_id) {
			$query_android->andWhere('md.city_id = ?', $city_id);
		}
	
		if ($app_version) {
			$query_android->andWhere('md.app_version = ?', $app_version);
		}
	
		if ($locale) {
			$query_android->andWhere('md.locale = ?', $locale);
		}
	
		return $query_android;
	}
	
	private function _getFormChoice() {
		$choices['version'] = null;
		$choices['locale'] = null;
		
		$query = Doctrine_Query::create()
				->select('md.app_version')
				->from('MobileDevice md')
				->where('md.app_version IS NOT NULL AND md.app_version != ?', '')
				->groupBy('md.app_version')
				->orderBy('md.app_version DESC')
				->fetchArray();
		
		foreach ($query as $ver) {
			$choices['version'][$ver['app_version']] = $ver['app_version'];
		}
		
		$query2 = Doctrine_Query::create()
				->select('md.locale')
				->from('MobileDevice md')
				->where('md.locale IS NOT NULL AND md.locale != ?', '')
				->groupBy('md.locale')
				->orderBy('md.locale ASC')
				->fetchArray();
		
		foreach ($query2 as $locale) {
			$choices['locale'][$locale['locale']] = $locale['locale'];
		}
		
		return $choices;
	}
	
	public function executeGetCountriesAutocomplete(sfWebRequest $request) {
		$culture = $this->getUser()->getCulture();
		$domain = sfContext::getInstance()->getRequest()->getHost();
		$domCom = (strstr($domain, '.my') || strstr($domain, '.com')) ? true : false;
		$this->getResponse()->setContentType('application/json');
	
		$q = "%" . $request->getParameter('term') . "%";
	
		$limit = $request->getParameter('limit', 20);

		$dql = Doctrine_Query::create()
				->from('Country c')
				->where('c.name LIKE ? OR c.name_en LIKE ?', array($q, $q))
				->andWhere('c.id < 251')
				->limit($limit);
	
		$this->rows = $dql->execute();
	
		$countries = array();
	
		foreach ($this->rows as $row) {
			$countries [] = array(
					'id' => $row ['id'],
					'value' => $row['name_en'].($domCom ? ' ('.$row ['id'].')' : '')
			);
		}
	
		return $this->renderText(json_encode($countries));
	}
	
	public function executeAutocomplete($request)
	{
		$domain = sfContext::getInstance()->getRequest()->getHost();
		$domCom = (strstr($domain, '.my') || strstr($domain, '.com')) ? true : false;
		$countryId=sfContext::getInstance()->getUser()->getCountry()->getId();
	
		$culture = $this->getUser()->getCulture();
		$this->getResponse()->setContentType('application/json');
	
		$q = "%" . $request->getParameter('term') . "%";
	
		$limit = $request->getParameter('limit', 10);

		$dql = Doctrine_Query::create()
		->from('City c')
		->innerJoin('c.Translation ctr')
		->where('ctr.name LIKE ? ',$q )
		->limit($limit);
	
		if ($countryId && !$domCom) {
			$dql->innerJoin('c.County cnty')
			->andWhere('cnty.country_id = ?', $countryId);
		}
	
		$this->rows = $dql->execute();
		$cities = $cities_names = array();
	
		$partner_class = getlokalPartner::getLanguageClass(getlokalPartner::getInstance());
	
		foreach ($this->rows as $city) {
			$cities [] = array(
					'id' => $city ['id'],
					'value' => $city->getCityNameByCulture() . ', ' . mb_convert_case($city->getCounty()->getCountyNameByCulture(), MB_CASE_TITLE, 'UTF-8').($domCom ? ' ('.$city ['id'].')' : '')
			);
		}
	
	
		return $this->renderText(json_encode($cities));
	}
	
	private function _getFilterParameters($params) {
		$message = $params['message'];
		$iOS = false;
		$android = false;
		
		$country_id = null;
		$country_gps = null;
		$city_id = null;
		$app_version = null;
		$locale = null;
		
		//device OS
		if ($params['device_os'] == 'iOS') {
			$iOS = true;
		}
		elseif ($params['device_os'] == 'Android') {
			$android = true;
		}
		else {
			$iOS = true;
			$android = true;
		}
		
		//App version
		if ($params['app_version'] && $params['app_version'] != '') {
			$app_version = $params['app_version'];
		}
		
		//Country id from user_profile
		if ($params['country_id']) {
			$country_id = $params['country_id'];
		}
		
		//Country id from GPS location
		if ($params['country_gps']) {
			$country_gps = $params['country_gps'];
		}
		
		//City id from user_profile
		if ($params['city_id']) {
			$city_id = $params['city_id'];
		}
		
		//locale
		if ($params['locale'] && $params['locale'] != '') {
			$locale = $params['locale'];
		}
		
		return array($message, $iOS, $android, $country_id, $country_gps, $city_id, $app_version, $locale);
	}
}