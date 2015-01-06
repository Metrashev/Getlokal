<?php use_helper('Link')?>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'bg'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'bg', 'my_company' => 1 ));?>


Здравейте<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' г-жо': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' г-н': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
За нас е удоволствие да приветстваме присъединяването на <?php echo $company->getCompanyTitleByCulture('bg');?> към най-голямата фирмена социална мрежа в България!
<br><br>

За да се възползвате максимално от преимуществата на нашия сайт, влезте във вашия профил от <a href="<?php echo $path?>"><?php echo 'тук';?></a> , използвайки е-мейл <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?> и вашата парола.
<br><br>Ако линкът не е активен, можете да го копирате и поставите в адресното полето на браузъра: 
<br><?php echo $path;?>
<br><br>Пример за страница на място можете да видите <a href="<?php echo $path_business?>"><?php echo 'тук' ;?></a>.
<br><br>Вече в профила си, създайте потребителско име и парола за мястото, което представлявате и актуализирайте неговата информация – бизнес описание, снимки, работно време, данни за контакт.
<br><br>Ако имате каквито и да е въпроси, не се колебайте да се свържете с нас на <a href="mailto:bcm@getlokal.com">bcm@getlokal.com</a>.<br>
Поздрави,<br>
Екипът на getlokal.com<br><br><br>

-----------------------------------------------
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'en'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en', 'my_company' => 1));?>
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>


It is our pleasure to welcome <?php echo $company->getCompanyTitleByCulture('en');?> on joining the largest social network for places and businesses in Bulgaria! 
<br><br>
To make the most of the benefits our website offers, click <a href="<?php echo $path?>"><?php echo 'here';?></a> and use <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?>  and your password to log in your profile. 
<br><br>If the link is not active please copy and paste it in the address bar:
<br><?php echo $path;?>
<br><br>Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.
<br><br>To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a>.
<br><br>


If you have any questions,please contact us at <a href="mailto:bcm@getlokal.com">bcm@getlokal.com</a><br>
Best Regards<br>
The getlokal.com team
