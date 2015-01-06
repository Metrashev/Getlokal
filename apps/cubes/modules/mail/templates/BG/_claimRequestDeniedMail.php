<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'bg'));?>

Здравейте <?php echo ($profile->getGender() == 'f')? ' г-жо': (($profile->getGender() == 'm')? ' г-н': '');?> <?php  if ($profile->getGender()): echo (($profile->getLastName())? $profile->getLastName():$profile->getFirstName()) ; endif;?>,
<br><br>
Вашата заявка за добавяне на <?php echo $company->getCompanyTitleByCulture('bg');?> към вашия бизнес профил в <a href="http://www.getlokal.com">www.getlokal.com</a> беше отхвърлена, защото с нея има проблем. 
<br><br>
Най-вероятно е имало разминаване в данните за фирмата, които сте ни изпратили и ние не сме успели да се свържем с вас на посочения телефон/и за контакт, за да установим достоверността им.
<br><br>
Моля влезте отново във вашия бизнес профил и проверете всички данни за контакт преди да добавите <?php echo $company->getCompanyTitleByCulture('bg');?> към него. 
<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>
Ние ще се опитаме да се свържем с вас до 3 работни дни след като получим новата заявка. Ако не получите обаждане от нас до 3 работни дни и заявката ви не е одобрена, моля пишете ни на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br><br>
Благодарим ви и ви пожелаваме приятно сърфиране!<br>
Екипът на getlokal.com<br><br><br>
-----------------------------------------------
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>

<br><br>
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($profile->getLastName())? $profile->getLastName():$profile->getFirstName() ; endif;?>,<br><br>

Your application for claiming <?php echo $company->getCompanyTitleByCulture('en');?> in <a href="http://www.getlokal.com/en">www.getlokal.com</a> has been rejected as there was a problem with it. <br><br>

This is most likely due to a discrepancy with the business information that we have for you and we haven't been able to contact you by phone to verify it.<br><br>

<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>


Please log into your business profile and check all the contact information again before you claim <?php echo $company->getCompanyTitleByCulture('en');?> again.<br><br>

We will try to contact you within 3 working days of receiving the new claim. If you don't hear from us within 3 working days and your claim is not approved please contact us at:<a href="mailto:info@getlokal.com">info@getlokal.com</a> 
<br><br>
Thank you very much and enjoy getlokal.com <br>
The getlokal.com team 




