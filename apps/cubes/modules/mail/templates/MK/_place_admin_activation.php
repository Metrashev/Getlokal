<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'mk', 'my_company' => 1 ));?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'mk'));?>
<?php $profile = $user->getUserProfile();?>

<?php echo ($profile->getGender() == 'f')? 'Почитувана г-а': (($profile->getGender() == 'm')? 'Почитуван г-дин': '');?> <?php  if ($profile->getGender()): echo ($profile->getLastName())? $profile->getLastName():$profile->getFirstName() ; endif;?>,

<br><br>

Ни представува задоволство да Ви посакаме добредојде во најголемата социјална мрежа за места и бизниси во Македонија!
<br><br>
Со цел да ги искористите придобивките кои ги нуди нашата веб-страна, кликнете <a href="<?php echo $path?>"><?php echo 'тукa' ;?></a>  и искористете ги овие детали <?php echo $profile->getsfGuardUser()->getEmailAddress();?> и <?php echo $password;?> за да се најавите на Вашиот профил.<br><br>
<i>Ве советуваме да ја промените автоматски генерираната лозинка веднаш по регистрирањето во Вашиот профил преку Подеувања/Подесувања на безбедност/Промени лозинка.</i>
<br><br>
Веднаш по регистрирањето, направете кориснично име и лозинка за местото и потоа ажурирајте ги информациите за истото – опис, класификации, слики, работно време, информации за локација и контакт.<br> <br>
За да видите како изгледа страна за место, Ве молиме кликнете <a href="<?php echo $path_business?>"><?php echo 'тукa' ;?></a>.
<br><br>
Доколку имате било какви прашања, Ве молиме контактирајте не на <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a>.<br>
Со почит,<br>
Тимот на getlokal.mk<br><br><br>

-----------------------------------------------
<br><br>
<?php $path_business = link_to_frontend('for_business', array('sf_culture'=>'en'));?>
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($user->getLastName())? $user->getLastName():$user->getFirstName() ; endif;?>,
<br><br>

It is our pleasure to welcome you to the largest social network for places and businesses in Macedonia! 
<br><br>

To make the most of the benefits our website offers, click <a href="<?php echo $path ?>"><?php echo 'here' ;?></a>  and use these details - email: <?php echo $profile->getsfGuardUser()->getEmailAddress();?> and password: <?php echo $password;?> to log in your profile. <br><br>
<i>We strongly advise you to change the automatically generated password right after you log into your profile from Settings/Security Settings/Change Password. </i>
<br><br>
Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.<br> <br>
To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a>.
<br><br>


If you have any questions,please contact us at <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
Best Regards<br>
The getlokal.mk team