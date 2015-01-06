<?php

/**
 * MobileLog
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class MobileLog extends BaseMobileLog
{

  public static function log($action, $foreign_id = null, $user_id = null)
  {
    // don't let an error in logging mess our process
    try {
      self::_log($action, $foreign_id, $user_id);
    } catch (Exception $e) {
      // var_dump($e->getMessage());
    }
  }

  public static function getOs()
  {
    $agent = sfContext::getInstance()->getRequest()->getHttpHeader('User-Agent');
    if (stristr($agent, 'iphone') || stristr($agent, 'ipad')) {
      return 'ios';
    }
    return 'android';
  }

  /**
   * Add Log entry
   */
  protected static function _log($action, $foreign_id = null, $user_id = null)
  {
    if (is_null($user_id)) {
      $user = sfContext::getInstance()->getUser();
      $user_id = $user->getId();
    }
    if (!$user_id) {
      return;
    }

    $request = sfContext::getInstance()->getRequest();

    $mobile_log = new MobileLog();

    $mobile_log->setUserId($user_id);
    $mobile_log->setAction($action);

    $mobile_log->setDevice(self::getOs());

    if ($lat = $request->getParameter('lat')) {
      $mobile_log->setLat($lat);
    }
    if ($lng = $request->getParameter('long')) {
      $mobile_log->setLng($lng);
    }

    if (!is_null($foreign_id)) {
      $mobile_log->setForeignId($foreign_id);
    }
    
    if (!is_null($foreign_id)) {
      $mobile_log->setForeignId($foreign_id);
    }
    if (strstr($request->getUri(), 'api21')) {
      $version = '2.1';
    } elseif (strstr($request->getUri(), 'api2')) {
      $version = '2';
    } elseif (strstr($request->getUri(), 'api201')) {
      $version = '2.01';
    } elseif (strstr($request->getUri(), 'api22')) {
      $version = '2.2';
    } elseif (strstr($request->getUri(), 'api30')) {
      $version = '3.0';
    } elseif (strstr($request->getUri(), 'api31')) {
      $version = '3.1';
    } elseif (strstr($request->getUri(), 'api32')) {
      $version = '3.2';
    } else {
      $version = '1';
    }
    $mobile_log->setVersion($version);

    $mobile_log->save();
  }

  public function getForeign()
  {
    $id = $this->getForeignId();
    if (!$id) {
      return null;
    }
    try {
      switch ($this->getAction()) {
        case 'company':
        case 'checkin':
        case 'follow':
          return (string) CompanyTable::getInstance()->find($id);
        case 'review':
          $review = ReviewTable::getInstance()->find($id);
          if (!$review) {
            break;
          }
          $company = $review->getCompany();
          $text = (string) $review->getText();
          if ($company) {
            $text = $company->getCompanyTitle() . ': ' . $text;
          }
          return $text;
        case 'upload':
          $image = ImageTable::getInstance()->find($id);
          if ($image) {
            return (string) $image->getThumb();
          }
        case 'getvoucher':
          return (string) CompanyOfferTable::getInstance()->find($id);
      }
    } catch (Expcetion $e) {}

    return null;
  }

  public function getDistance()
  {
    $actions = array(
      'company', 'review'
    );
    if (!in_array($this->getAction(), $actions)) {
      return '';
    }

    $l1 = array($this->getLat(), $this->getLng());
    $id = $this->getForeignId();
    try {
      switch ($this->getAction()) {
        case 'company':
          $l2 = CompanyTable::getLatLngById($id);
          break;
        case 'review':
          $review = ReviewTable::getInstance()->find($id);
          if (!$review) {
            return 'N/A';
          }
          $location = $review->getCompany()->getCompanyLocation();
          if (empty($location)) {
            $l2 = null;
            break;
          }
          $location = $location[0];
          if ($location) {
            $l2 = array($location->getLatitude(), $location->getLongitude());
          }
          break;
      }

      if ($l1 && $l2) {
        return myTools::distance($l1[0], $l1[1], $l2[0], $l2[1]) . ' Km';
      }
    } catch (Exception $e) {}

    return 'N/A';
  }

}
