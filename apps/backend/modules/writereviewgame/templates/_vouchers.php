<?php
  $user_review_vouchers = $user_profile->getVouchersReviews($from, $to);
  $count = count($user_review_vouchers);
  echo $count; 
?>
<?php if ($count > 0 ):?></br></br>
<?php foreach($user_review_vouchers as $user_review_voucher):?>
 <span style="background-color:#CEFDE2;"><?php echo $user_review_voucher->getVoucher()?>, issued on <?php echo $user_review_voucher->getDateIssued()?></span></br>
 <?php endforeach;?>
 <?php endif;?>