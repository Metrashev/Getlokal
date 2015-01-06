<?php use_helper('Link')?>
<?php $profile = $user->getUserProfile();?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'hu', 'my_company' => 1 ));?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'hu'));?>


Tisztelt <?php echo ($profile->getGender() == 'f')? ' Asszony': (($profile->getGender() == 'm')? ' Úr': '');?> <?php  if ($profile->getGender()): echo (($user->getLastName())? $user->getLastName():$user->getFirstName()) ; endif;?>,
<br><br>

Örömmel üdvözöljük a csatlakozását a legnagyobb hely és üzleti társadalmi halózathoz Bulgáriában! 
<br><br>
A honlapunk által nyújtott előnyök legjobb kihasználásához, kattintson <a href="<?php echo $path ?>"><?php echo 'ide' ;?></a>  és használja a következő részleteket - email-t: <?php echo $profile->getsfGuardUser()->getEmailAddress();?> és jelszót: <?php echo $password;?>, hogy belépjen a profiljába.
<br><br>Ha a link nem aktiv másolja le azt és illessze be a címsorba:
<br><?php echo $path;?>
<br><br>
<i>Tanáçsoljuk, mihelyt belép a profiljába, azonnal megváltoztatni az automatikusan generált jelszót a Beállítások/Bíztonsági beállítások/Jelszóváltoztatás menűből.</i>
<br><br>
Ha már belépett, hozzon létre felhasználónevet és jelszót a helynek amit képvisel és utána frissítse fel az információt róla - bizniszleírást, képeket, munkaidőt, elérhetőségeket.
<br> <br>
Hogyan néz ki egy helyoldal láthatja <a href="<?php echo $path_business?>"><?php echo 'itt' ;?></a> .
<br><br>
Ha bármilyen kérdése lenne, lépjen kapcsolatba velünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com-ban</a>.<br>
Üdvözlettel,<br>
getlokal.hu csapata<br><br><br>

-----------------------------------------------
<br><br>
<?php $path_business = link_to_frontend('for_business', array('sf_culture'=>'en'));?>
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($user->getLastName())? $user->getLastName():$user->getFirstName() ; endif;?>,
<br><br>

It is our pleasure to welcome you to the largest social network for places and businesses in Bulgaria! 
<br><br>

To make the most of the benefits our website offers, click <a href="<?php echo $path ?>"><?php echo 'here' ;?></a>  and use these details - email: <?php echo $profile->getsfGuardUser()->getEmailAddress();?> and password: <?php echo $password;?> to log in your profile. 
<br><br>If the link is not active please copy and paste it in the address bar:
<br><?php echo $path ;?>
<br><br>
<i>We strongly advise you to change the automatically generated password right after you log into your profile from Settings/Security Settings/Change Password. </i>
<br><br>
Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.<br> <br>
To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?>.
<br><br>


If you have any questions,please contact us at <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Best Regards<br>
The getlokal.hu team
