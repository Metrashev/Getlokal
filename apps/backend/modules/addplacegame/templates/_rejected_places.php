<?php
  $companies= $user_profile->getSugestedCompanies(CompanyTable::REJECTED, $from, $to);
  $count = count($companies);
  echo $count;
?>
<?php if ($count > 0 ):?></br></br>
<?php foreach($companies as $company):?>
<span style="background-color:#FFCCCC;"><?php echo link_to($company->getTitle(), '/en/'.$company->getSlug(),array('popup'=>true)); ?></span></br>
 <?php endforeach;?>
 <?php endif;?>
