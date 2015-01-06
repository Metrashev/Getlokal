<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'ro', 'my_company' => 1 ));?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'ro'));?>
<?php $profile = $user->getUserProfile();?>

Dragă<?php echo ($profile->getGender() == 'f')? ' D-na': (($profile->getGender() == 'm')? ' D-nul': '');?> <?php  if ($profile->getGender()):  echo ($profile->getLastName())? $profile->getLastName():$profile->getFirstName() ; endif;?>,

<br><br>

Îți urăm bun venit în cea mai mare rețea de socializare pentru localuri și companii din România!
<br><br>
Pentru a te bucura de cât mai multe dintre beneficiile pe care le oferă site-ul nostru, apasă <a href="<?php echo $path?>"><?php echo 'aici' ;?></a> și folosește aceste detalii <?php echo $profile->getsfGuardUser()->getEmailAddress();?> si <?php echo $password;?> pentru a te autentifica.<br><br>
<i>Te sfătuim sa schimbi parola generată automat imediat ce te autentifici, din Setări/Setări de Securitate/Schimbă parola.</i>
<br><br>
Odată autentificat, creează un nume de utilizator al locului și o parolă și apoi actualizează informațiile locului – descriere, fotografii, program orar, date de contact.<br> <br>
Dacă vrei să vezi cum arată pagina unui loc, te rugăm să apeși <a href="<?php echo $path_business?>"><?php echo 'aici' ;?></a>.
<br><br>
Dacă ai întrebări, te rugăm să ne contactezi la <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>.<br>
Toate cele bune,<br>
Echipa getlokal.ro<br><br><br>

-----------------------------------------------
<br><br>
<?php $path_business = link_to_frontend('for_business', array('sf_culture'=>'en'));?>
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($user->getLastName())? $user->getLastName():$user->getFirstName() ; endif;?>,
<br><br>

It is our pleasure to welcome you to the largest social network for places and businesses in Romania! 
<br><br>

To make the most of the benefits our website offers, click <a href="<?php echo $path ?>"><?php echo 'here' ;?></a> and use these details - email: <?php echo $profile->getsfGuardUser()->getEmailAddress();?> and password: <?php echo $password;?> to log in your profile. <br><br>
<i>We strongly advise you to change the automatically generated password right after you log into your profile from Settings/Security Settings/Change Password. </i>
<br><br>
Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.<br> <br>
To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a>.
<br><br>


If you have any questions,please contact us at <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br>
Best Regards<br>
The getlokal.ro team
