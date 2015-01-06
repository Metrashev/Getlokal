<?php
  $companies= $user_profile->getSugestedCompanies('all', $from, $to);
  $count = count($companies);
  echo $count;
?>
<?php if ($count > 0 ):?></br></br>
<?php foreach($companies as $company):?>
<span style="background-color:#9999FF;"><?php echo link_to($company->getTitle(), '/en/'.$company->getSlug(),array('popup'=>true)); ?></span></br>
 <?php endforeach;?>
 <?php endif;?>
