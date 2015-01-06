<?php use_helper('Link')?>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'en'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>


It is our pleasure to welcome <?php echo $company->getCompanyTitleByCulture('en');?> on joining the largest social network for places and businesses in Bulgaria! 
<br><br>
To make the most of the benefits our website offers, click <a href="<?php echo $path?>"><?php echo 'here';?></a> and use <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?>  and your password to log in your profile. 
<br><br>If the link is not active please copy and paste it in the address bar:
<br><?php echo $path ;?>
<br><br>Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.<br> <br>
To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a>.
<br><br>


If you have any questions,please contact us at <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Best Regards<br>
The getlokal.fi team
