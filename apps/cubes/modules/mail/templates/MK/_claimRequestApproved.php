<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>
<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,

<br /><br />
We approved your request and <?php echo $company->getCompanyTitleByCulture('en');?> is now linked to your profile on <a href="http://www.getlokal.mk/en">www.getlokal.mk</a>.
<br /><br />
Click on the link below and log into your account. If the link is not active please copy and paste it in the address bar.
<br><br>
<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitleByCulture('en');?> as well as to respond to user reviews. We will be adding more options for companies to attract customers via getlokal.com and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br />
<br />
Thank you very much and enjoy getlokal.mk! <br />
The getlokal.mk team
