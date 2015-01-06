<?php use_helper('Link')?>
<?php $profile = $user->getUserProfile();?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'bg', 'my_company' => 1 ));?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'bg'));?>


Здравейте <?php echo ($profile->getGender() == 'f')? ' г-жо': (($profile->getGender() == 'm')? ' г-н': '');?> <?php  if ($profile->getGender()): echo (($user->getLastName())? $user->getLastName():$user->getFirstName()) ; endif;?>,
<br><br>

За нас е удоволствие да приветстваме присъединяването ви към най-голямата фирмена социална мрежа в България!
<br><br>
За да се възползвате максимално от преимуществата на нашия сайт, използвайте следните данни - имейл: <?php echo $profile->getsfGuardUser()->getEmailAddress();?> и парола: <?php echo $password;?>, за да влезете във вашия профил от <a href="<?php echo $path?>"><?php echo 'тук' ;?></a>.
<br><br>Ако линкът не е активен, можете да го копирате и поставите в адресното полето на браузъра:
<br><?php echo $path;?>
<br><br>
<i>Съветваме ви да смените автоматично генерираната парола веднага щом влезете в профила си от Настройки/Сигурност/Промяна на парола.</i>
<br><br>
Вече в профила си, създайте потребителско име и парола за мястото, което представлявате и актуализирайте неговата информация – бизнес описание, снимки, работно време, данни за контакт.  <br> <br>
Пример за страница на място можете да видите <a href="<?php echo $path_business?>"><?php echo 'тук' ;?></a> .
<br><br>
Ако имате каквито и да е въпроси, не се колебайте да се свържете с нас на <a href="mailto:bcm@getlokal.com">bcm@getlokal.com</a>.<br>
Поздрави,<br>
Екипът на getlokal.com<br><br><br>

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


If you have any questions,please contact us at <a href="mailto:bcm@getlokal.com">bcm@getlokal.com</a><br>
Best Regards<br>
The getlokal.com team
