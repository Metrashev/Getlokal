<?php
/**
 * company actions.
 *
 * @package    getLokal
 * @subpackage crop
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cropActions extends sfActions {
	protected function configPlaceImage(sfWebRequest $request) {
		$is_getlokal_admin = (($this->getUser ()->getGuardUser () && in_array ( $this->getUser ()->getGuardUser ()->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? true : false);
		$this->user_is_admin = false;
		
		if ((! $this->getUser ()->getPageAdminUser () && ! $is_getlokal_admin) or ! $this->getUser ()->getGuardUser ()) {
			if ($request->getParameter ( 'slug' )) {
				$this->redirect ( 'companySettings/login?slug=' . $request->getParameter ( 'slug' ) );
			} else {
				$this->redirect ( 'companySettings/login' );
			}
		}
		if ($is_getlokal_admin) {
			$this->adminuser = null;
			$this->user = $this->getUser ()->getGuardUser ();
		} else {
			$this->adminuser = $this->getUser ()->getPageAdminUser ();
			$this->user = $this->adminuser->getUserProfile ()->getsfGuardUser ();
			$this->user_is_admin = true;
		}
		$query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' );
		if (! $is_getlokal_admin) {
			$query->innerJoin ( 'c.CompanyPage p' )->innerJoin ( 'p.PageAdmin a' )->where ( 'a.id = ?', $this->adminuser->getId () )->andWhere ( 'a.status = ?', 'approved' );
		}
		$this->forwardUnless ( $request->getParameter ( 'slug' ), 'userSettings', 'companySettings' );
		$query->andWhere ( 'c.slug = ?', $request->getParameter ( 'slug' ) );
		$this->company = $query->fetchOne ();
		$this->forwardUnless ( $this->company, 'userSettings', 'companySettings' );
		$this->company->setUser ( $this->getUser () );
	}
	public function executePlacePhoto(sfWebRequest $request) {
		$this->configPlaceImage ( $request );
		if ($this->getRequestParameter ( 'image_id' )) {
			$image = Doctrine::getTable ( 'Image' )->findOneById ( $this->getRequestParameter ( 'image_id' ) );
			if ($image) {
				$o_filename = $image->getFile ()->getDiskPath ();
			
			} else {
				$this->getUser ()->setFlash ( 'error', 'Image was not saved successfully.' );
			}
		} else {
			$this->getUser ()->setFlash ( 'error', 'No image selected' );
			$this->redirect ( 'companySettings/images?slug=' . $this->company->getSlug () );
		}
		list ( $this->img_width, $this->img_height ) = getimagesize ( $o_filename );
		if ($request->isMethod ( 'post' )) {
		  if ($this->getRequestParameter ( 'width' )) {
			
			$width = $this->getRequestParameter ( 'width' );
			
			$height = $this->getRequestParameter ( 'height' );
			$x1 = $this->getRequestParameter ( 'x1' );
			$y1 = $this->getRequestParameter ( 'y1' );
			$x2 = $this->getRequestParameter ( 'x2' );
			$y2 = $this->getRequestParameter ( 'y2' );
			
			if ($o_filename) {
				
				$ext = pathinfo ( $o_filename, PATHINFO_EXTENSION );
				$new_name = substr ( uniqid ( md5 ( rand () . date ( 'Y-m-d h:i:s' ) ), true ), 0, 8 );
				$new_filename = sfConfig::get ( 'sf_upload_dir' ) . '/covers/' . $new_name . '.' . $ext;
				
				$im = new ImageManipulator ( $o_filename );
				$im->crop ( $x1, $y1, $x2, $y2 ); // takes care of out of boundary conditions automatically
				

				try {
					$con = Doctrine::getConnectionByTableName ( 'Image' );
					$con->beginTransaction ();
					$im->save ( sfConfig::get ( 'sf_upload_dir' ) . '/covers/' . $new_name . '.' . $ext );
					//$image_save_func ( $final, $new_filename, 9 );
					$this->image = new CoverImage ();
					$this->image->setFilename ( $new_name . '.' . $ext );
					$this->image->setCaption ( $image->getCaption () );
					$this->image->setUserId ( $this->user->getId () );
					$this->image->setCompanyId ( $this->company->getId () );
					$this->image->setStatus ( 'approved' );
					$this->image->save ();
					//if (! $this->company->getCoverImageId ()) {
					$this->company->setCoverImageId ( $this->image->getId () );
					$this->company->save ();
					//}
					$con->commit ();
				} catch ( Exception $e ) {
					$con->rollBack ();
					$this->getUser ()->setFlash ( 'error', 'Image was not saved successfully.' );
				}
				imagedestroy ( $im );
				//imagedestroy ( $final );
				$this->getUser ()->setFlash ( 'notice', 'The photo was published successfully.' );
				$this->redirect ( 'companySettings/coverImages?slug=' . $this->company->getSlug () );
			} else {
				$this->getUser ()->setFlash ( 'error', 'Image was not saved successfully.' );
			}
		
		  } else {
			$this->getUser ()->setFlash ( 'error', 'You need to select a crop area in your image.' );
		    $this->image = $image;
		  }
		}
		else {
			$this->image = $image;
		}
	}
	
	public function executeSetCoverImage(sfWebRequest $request) {
		$this->configPlaceImage ( $request );
		
		if ($this->getRequestParameter ( 'image_id' )) {
			
			$image = Doctrine::getTable ( 'Image' )->findOneById ( $this->getRequestParameter ( 'image_id' ) );
			if ($image) {
				$o_filename = $image->getFile ()->getDiskPath ();
			
			} else {
				$this->getUser ()->setFlash ( 'error', 'Image was not saved successfully.' );
			}
		} else {
			$this->getUser ()->setFlash ( 'error', 'No image selected' );
			$this->redirect ( 'companySettings/images?slug=' . $this->company->getSlug () );
		}
		list ( $this->img_width, $this->img_height ) = getimagesize ( $o_filename );
		if ($o_filename) {
			
			$ext = pathinfo ( $o_filename, PATHINFO_EXTENSION );
			$new_name = substr ( uniqid ( md5 ( rand () . date ( 'Y-m-d h:i:s' ) ), true ), 0, 8 );
			$new_filename = sfConfig::get ( 'sf_upload_dir' ) . '/covers/' . $new_name . '.' . $ext;
			
			$im = new ImageManipulator ( $o_filename );
			$im->crop ( 0, 0, 975, 300 ); // takes care of out of boundary conditions automatically
			

			try {
				$con = Doctrine::getConnectionByTableName ( 'Image' );
				$con->beginTransaction ();
				$im->save ( sfConfig::get ( 'sf_upload_dir' ) . '/covers/' . $new_name . '.' . $ext );
				//$image_save_func ( $final, $new_filename, 9 );
				$this->image = new CoverImage ();
				$this->image->setFilename ( $new_name . '.' . $ext );
				$this->image->setCaption ( $image->getCaption () );
				$this->image->setUserId ( $this->user->getId () );
				$this->image->setCompanyId ( $this->company->getId () );
				$this->image->setStatus ( 'approved' );
				$this->image->save ();
				//if (! $this->company->getCoverImageId ()) {
				$this->company->setCoverImageId ( $this->image->getId () );
				$this->company->save ();
				//}
				$con->commit ();
			
			} catch ( Exception $e ) {
				$con->rollBack ();
				$this->getUser ()->setFlash ( 'error', 'Image was not saved successfully.' );
			}
			
			//imagedestroy ( $final );
			$this->getUser ()->setFlash ( 'notice', 'The photo was published successfully.' );
			$this->redirect ( 'companySettings/coverImages?slug=' . $this->company->getSlug () );
		} else {
			$this->getUser ()->setFlash ( 'error', 'Image was not saved successfully.' );
		}
	
	}
	
	public function executeUpload(sfWebRequest $request) {
		$this->configPlaceImage ( $request );
		$photo = new CoverImage ();
		$photo->setUserId ( $this->user->getId () );
		$photo->setCompanyId ( $this->company->getId () );
		$photo->setStatus ( 'approved' );
		$this->form = new CoverImageForm ( $photo );
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ), $request->getFiles ( $this->form->getName () ) );
			
			if ($this->form->isValid ()) {
				
				$this->company->setCoverImageId ( $photo->getId () );
				$this->company->save ();
				$this->getUser ()->setFlash ( 'notice', 'The photo was published successfully.' );

          $this->redirect ( 'companySettings/coverImages?slug=' . $this->company->getSlug () );
        }
      }
    }
    
    
	
}
