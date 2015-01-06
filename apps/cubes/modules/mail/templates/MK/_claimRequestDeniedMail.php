<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>

Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($profile->getLastName())? $profile->getLastName():$profile->getFirstName() ; endif;?>,<br><br>

Your application for claiming <?php echo $company->getCompanyTitleByCulture('en');?> in <a href="http://www.getlokal.mk/en">www.getlokal.mk</a> has been rejected as there was a problem with it. <br><br>

This is most likely due to a discrepancy with the business information that we have for you and we haven't been able to contact you by phone to verify it.<br><br>

<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>


Please log into your business profile and check all the contact information again before you claim <?php echo $company->getCompanyTitleByCulture('en');?> again.<br><br>

We will try to contact you within 3 working days of receiving the new claim. If you don't hear from us within 3 working days and your claim is not approved please contact us at:<a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a> 
<br><br>
Thank you very much and enjoy getlokal.mk <br>
The getlokal.mk team 




