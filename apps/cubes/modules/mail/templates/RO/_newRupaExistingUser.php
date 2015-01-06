<?php use_helper('Link')?>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'ro'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'ro', 'my_company' => 1));?>


Dragă 
<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' D-na': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' D-nul': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
Îți uram bun venit in cea mai mare rețea de socializare pentru localuri și companii din România!
<br><br>

Pentru a te bucura de cât mai multe dintre beneficiile pe care le oferă site-ul nostru, apasă <a href="<?php echo $path?>"><?php echo 'aici';?></a> ( <?php echo $path?> ) și folosește e-mailul <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?> ) si parola ta pentru a te autentifica.<br><br>
Odată autentificat, creează un nume de utilizator al locului și o parolă și apoi actualizează informațiile – descrierea companiei, fotografii, program orar, date de contact.<br><br>
Dacă vrei să vezi cum arată pagina unui loc, te rugăm să apeși <a href="<?php echo $path_business?>"><?php echo 'aici' ;?></a> (<?php echo $path_business?>).
<br><br>
Dacă ai întrebări, te rugăm să ne contactezi la <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>.<br>
Toate cele bune,<br>
Echipa getlokal.ro<br><br><br>

-----------------------------------------------
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'en'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en', 'my_company' => 1));?>
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>

It is our pleasure to welcome <?php echo $company->getCompanyTitleByCulture('en');?> on joining the largest social network for places and businesses in Romania! 
<br><br>
To make the most of the benefits our website offers, click <a href="<?php echo $path?>"><?php echo 'here';?></a> ( <?php echo $path?> ) and use <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?>  and your password to log in your profile. <br><br>
Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.<br> <br>

To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a> (<?php echo $path_business?>).
<br><br>


If you have any questions,please contact us at <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br>
Best Regards<br>
The getlokal.ro team
