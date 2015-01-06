<?php //include_partial('review/reviewJs');?>
<?php include_partial('review', array('review' => $review, 'review_user' => true, 'user' => $user, 'edit'=>'1'
, 'user_is_admin' =>$user_is_admin,'user_is_company_admin'=>$user_is_company_admin) ) ?>
