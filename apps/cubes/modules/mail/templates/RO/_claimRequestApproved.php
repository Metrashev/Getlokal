<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'ro'));?>
<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
Bună ziua
<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' D-na': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' D-nul': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,

<br />
<br />
Cererea ta a fost aprobată! Acum, pagina de pe getlokal.ro a <?php echo $company->getCompanyTitleByCulture('ro');?> este asociată profilului tău de pe site-ul nostru!
<br />
<br />
Dă click pe linkul de mai jos și intră în cont
<br />
<br />
<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>

Din pagina de setări, intră în Locurile Mele și introdu-ți username-ul <?php echo $pageAdmin->getUsername();?> și parola aleasă pentru <?php echo $company->getCompanyTitleByCulture('ro');?>.
<br><br>
Vei putea să postezi fotografii, programul de lucru și o descriere a <?php echo $company->getCompanyTitleByCulture('en');?> și vei putea intra în dialog cu clienții, răspunzându-le pe site.
<br><br>
Lucrăm la a îmbogăți modalitățile prin care îți venim în ajutor pentru promovare, așa că stai pe-aici, te anunțăm de îndată ce lansăm noi funcționalități!

<br><br>
Dacă ai întrebări, le așteptăm pe  <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>. Răspundem cât de repede putem!<br />

Mulţumim şi un surffing plăcut!
Echipa getlokal.ro

<br /><br /><br />

-----------------------------------------------
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>
<br /><br />
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,

<br /><br />
We approved your request and <?php echo $company->getCompanyTitleByCulture('en');?> is now linked to your profile on <a href="http://www.getlokal.ro/en">www.getlokal.ro</a>.
<br /><br />
Click on the link below and log into your account. If the link is not active please copy and paste it in the address bar.
<br><br>
<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitleByCulture('en');?> as well as to respond to user reviews. We will be adding more options for companies to attract customers via getlokal.com and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br />
<br />
Thank you very much and enjoy getlokal.ro! <br />
The getlokal.ro team
