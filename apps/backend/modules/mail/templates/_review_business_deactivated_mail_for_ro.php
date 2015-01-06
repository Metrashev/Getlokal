Buna ziua,<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' D-na': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' D-nul': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br /><br />
Opinia despre firma dumneavoastră <?php echo $company->getCompanyTitleByCulture('ro');?> publicată la data de <?php echo $date;?> de către un utilizator din <a href="http://www.getlokal.ro/">www.getlokal.ro</a> a fost dezactivată, deoarece încalcă  <a href="http://www.getlokal.ro/ro/page/4/Terms_of_Use">Condiţiile de utilizarе</a>.
<br /><br />
Toate opiniile despre <?php echo $company->getCompanyTitleByCulture('ro');?>, le puteţi vedea la adresa:<br />
http://www.getlokal.ro/ro/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br />
<br />
Dacă doriţi să răspundeţi unei opinii scrise de un utilizator despre firma dumneavoastră, intraţi în profilul dumneavoastră de firmă din
<a href="http://www.getlokal.ro/ro/login">http://www.getlokal.ro/</a> şi accesaţi „Răspunsuri”, de lângă opinii.
Răspunsul dumneavoastră va fi publicat din numele <?php echo $company->getCompanyTitleByCulture('ro');?>.
<br /><br />
Pentru orice fel de întrebări, nu ezitaţi să luaţi legătura cu noi, la: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>.
<br /><br />
Vă mulţumim şi un surffing plăcut!<br />
Echipa getlokal.ro
<br /><br /><br />

-----------------------------------------------
<br /><br />
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br /><br />
The review published about <?php echo $company->getCompanyTitleByCulture('en');?> on <?php echo $date;?> by a user of <a href="http://www.getlokal.ro/en">www.getlokal.ro</a>
was deactivated by one of our moderators as it violates the <a href="http://www.getlokal.ro/en/page/terms-of-use">Terms of Use</a>.
<br /><br />
You can see all reviews for <?php echo $company->getCompanyTitleByCulture('en');?> at the address below:<br />
http://www.getlokal.ro/en/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br /><br />

If you would like to reply to a review that has been posted about your company, log into your company profile <a href="http://www.getlokal.ro/en/login">http://www.getlokal.ro/</a> and click on 'Reply' next to the review. Your reply will be published on behalf of <?php echo $company->getCompanyTitleByCulture('en');?>.
<br /><br />
If you have any questions, feel free to write to us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>
<br /><br />
Thank you very much and enjoy getlokal.ro <br />
The getlokal.ro team

<?php include_partial('mail/mail_footer_ro');?>