<?php use_helper('Link')?>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'hu'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'hu', 'my_company' => 1 ));?>


Tisztelt<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Asszony': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Úr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Örömmel üdvözöljük a <?php echo $company->getCompanyTitle('hu');?> csatlakozását a legnagyobb hely és üzleti társadalmi halózathoz Bulgáriában!
<br><br>

A honlapunk által nyújtott előnyök legjobb kihasználásához, kattintson <a href="<?php echo $path?>"><?php echo 'ide';?></a>és <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?>használja a jelszavát belépni a profiljába.
<br><br>Ha a kapsolat nem aktiv, másolja le és illessze be azt a címsorba: 
<br><?php echo $path;?>
<br><br>Ha már belépett, hozzon létre felhasználónevet és jelszót a helynek amit képvisel és utána frissítse fel az információt róla - bizniszleírást, képeket, munkaidőt, elérhetőségeket.
<br><br>Hogyan néz ki egy helyoldal láthatja  <a href="<?php echo $path_business?>"><?php echo 'itt' ;?></a>.
<br><br>Ha bármilyen kérdése lenne, lépjen kapcsolatba velünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a>.<br>-on
Üdvözöljük<br>
getlokal.hu csapata<br><br><br>

-----------------------------------------------
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'en'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en', 'my_company' => 1));?>
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>


It is our pleasure to welcome <?php echo $company->getCompanyTitle('en');?> on joining the largest social network for places and businesses in Bulgaria! 
<br><br>
To make the most of the benefits our website offers, click <a href="<?php echo $path?>"><?php echo 'here';?></a> and use <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?>  and your password to log in your profile. 
<br><br>If the link is not active please copy and paste it in the address bar:
<br><?php echo $path;?>
<br><br>Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.
<br><br>To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a>.
<br><br>


If you have any questions,please contact us at <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Best Regards<br>
The getlokal.hu team
