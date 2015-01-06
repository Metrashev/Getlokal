Poštovanje<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' gdo.': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' g.': '');?> <?php if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
Preporuka objavljena za <?php echo $company->getCompanyTitleByCulture('en');?> dana <?php echo $date;?> od strane korisnika portala <a href="http://www.getlokal.me">http://www.getlokal.me</a> 
je deaktivirana od strane našeg administratora zbog kršenja <a href="http://www.getlokal.com/me/page/terms-of-use">Pravila korišcenja</a>. 
<br><br>

Možete procitati sve preporuke za <?php echo $company->getCompanyTitleByCulture('me');?> na sledecem linku:<br>

http://www.getlokal.me/me/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br><br>

Ukoliko želite da odgovorite na preporuke napisane za Vašu firmu ulogujte se na profil svoje firme <a href="http://www.getlokal.me/me/login">http://www.getlokal.me</a> i kliknite na 'Odgovori' odmah pored preporuke. Vaš odgovor ce biti objavljen u ime <?php echo $company->getCompanyTitleByCulture('me');?>.

<br><br>
<p>Za sva dodatna pitanja kontaktiraj nas na: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
<p>Uživaj koristeci getlokal,</p>
<p>Getlokal.me tim</p>
<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
The review published about <?php echo $company->getCompanyTitleByCulture('en');?> on <?php echo $date;?> by a user of <a href="http://www.getlokal.com/en">http://www.getlokal.com</a> 
was deactivated by one of our moderators as it violates the <a href="http://www.getlokal.com/en/page/terms-of-use">Terms of Use</a>. 
<br><br>
You can see all reviews for <?php echo $company->getCompanyTitleByCulture('en');?> at the address below:<br>
http://www.getlokal.com/en/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br><br>

If you would like to reply to a review that has been posted about your company, log into your company profile <a href="http://www.getlokal.com/bg/login">http://www.getlokal.com</a> and click on 'Reply' next to the review. Your reply will be published on behalf of <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a>
<br><br>
Thank you very much and enjoy getlokal.com <br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?> 