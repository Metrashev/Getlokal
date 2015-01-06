<?php use_helper('Link')?>
<?php $path = link_to_frontend('company', array('sf_culture'=>'hu', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Kedves <?php echo $profile->getFirstName();?>,<br>
Köszönjünk! A (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitle('hu');?></a>)hely, amit javasoltál a honlapunkba jóvá lett hagyva!
<br><br>
Már írhatsz megjegyzést róla, képeket tölthetsz fel és megoszthatod a tapasztalatodat más emberekkel, olyanok mint te:)<br>
<a href="<?php echo $path?>"><?php echo $company->getCompanyTitle('hu');?></a>
<br><br>
Ha van valami kérdésed nyugodtan írjál nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com-ra</a>.<br>
Élvezzd a getlokal.hu-ot!<br>
getlokal.hu csapata<br><br><br>

-----------------------------------------------
<br><br>
<?php $path = link_to_frontend('company', array('sf_culture'=>'en', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Dear, <?php echo $profile->getFirstName();?><br>
Thank you! The place (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitle('en');?></a>) you suggested to us was approved!
<br><br>
You can now review it, post pictures and share your experience with other people like you :)
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Enjoy getlokal.hu!<br>
The getlokal.hu team
