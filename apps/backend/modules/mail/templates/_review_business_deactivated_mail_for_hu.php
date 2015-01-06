Tisztelt <?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Asszony': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Úr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
A megjegyzést  az Ön  <?php echo $company->getCompanyTitle('hu');?> cégéről, amelyet  
<?php echo $date;?>-ban megjelentett a  <a href="http://www.getlokal.hu/">www.getlokal.hu</a> felhasználója 
a moderátorunk deaktiválta , mert az megszegi  <a href="http://www.getlokal.hu/hu/page/terms-of-use">Felhasználói feltételeit</a>.
<br><br>
Minden megjegyzést <?php echo $company->getCompanyTitle('hu');?>-ról láthatja a lejjebbi címen<br>
http://www.getlokal.hu/hu/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br><br>
Ha válaszolni akar a cégéről megjelentett megjegyzésnek, lépjen be a cégprofiljába <a href="http://www.getlokal.hu/hu/login">http://www.getlokal.hu</a>-ban és kattintson a "Válassz"-ra a  megjegyzés mellett. A válasza meg lesz jelentetve a <?php echo $company->getCompanyTitle('hu');?>cég nevében.
<br><br>
Ha van valami kérdése nyugodtan írjon nekünk<a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a> címre.
<br><br>
Nagyon szépem köszönjük és élvezze a getlokal.hu-ot!<br>
getlokal.hu csapata
<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
The review published about <?php echo $company->getCompanyTitle('en');?> on <?php echo $date;?> by a user of <a href="http://www.getlokal.hu/en">http://www.getlokal.hu</a> 
was deactivated by one of our moderators as it violates the <a href="http://www.getlokal.hu/en/page/terms-of-use">Terms of Use</a>. 
<br><br>
You can see all reviews for <?php echo $company->getCompanyTitle('en');?> at the address below:<br>
http://www.getlokal.hu/en/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br><br>

If you would like to reply to a review that has been posted about your company, log into your company profile <a href="http://www.getlokal.hu/en/login">http://www.getlokal.hu</a> and click on 'Reply' next to the review. Your reply will be published on behalf of <?php echo $company->getCompanyTitle('en');?>.
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a>
<br><br>
Thank you very much and enjoy getlokal.hu <br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?> 