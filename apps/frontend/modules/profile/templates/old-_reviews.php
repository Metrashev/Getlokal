<?php foreach ($pager->getResults() as $review):?>
			    	<?php $user_is_company_admin = (($user && $user->getIsPageAdmin ( $review->getCompany() )) ? true : false);
			          $user_is_admin=false; 
					  if ($is_other_place_admin_logged) :			
						$admin = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'a' )->where ( 'a.id = ?', $page_admin->getId () )->andWhere ( 'a.status = ?', 'approved' )->andWhere ( 'a.page_id = ?', $review->getCompany()->getCompanyPage ()->getId () )->fetchOne ();
						if ($admin) :
							$user_is_admin = true;
						endif;
					endif;?>
					<li class="user_review">
			      		<?php include_partial('review/review', array('review' => $review, 'user'=>$user, 'user_is_admin'=>$user_is_admin, 'user_is_company_admin'=>$user_is_company_admin)); ?>
			  		</li>
		     	<?php endforeach;?>