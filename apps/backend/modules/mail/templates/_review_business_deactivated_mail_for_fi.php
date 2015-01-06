Hyvä<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Rouva': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Herra': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Julkaistu arviointi <?php echo $company->getCompanyTitleByCulture('fi');?> sta <?php echo $date;?> käyttäjän <a href="http://www.getlokal.fi/">www.getlokal.fi</a> 
on poistettu sivuston ylläpitäjän toimesta, koska se rikkoo <a href="http://www.getlokal.fi/fi/page/terms-of-use">Käyttöehtoja</a>.
<br><br>
Voit nähdä kaikki arvioinnit <?php echo $company->getCompanyTitleByCulture('fi');?> alla olevasta osoitteesta:<br>
http://www.getlokal.com/bg/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br><br>
Jos haluat vastata yrityksestäsi tehtyyn arviointiin, kirjaudu sisään yrityksesi profiiliin <a href="http://www.getlokal.fi/fi/login">http://www.getlokal.fi</a> and click on 'Reply' next to the review. Your reply will be published on behalf of <?php echo $company->getCompanyTitleByCulture('fi');?>.
<br><br>
Jos Sinulla on kysyttävää, ota yhteyttä kirjoittamalla meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.
<br><br>
Toivomme, että viihdyt getlokal.fi palvelun parissa<br>
The getlokal.fi team

<br><br>
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
If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>
<br><br>
Thank you very much and enjoy getlokal.com <br>
The getlokal.com team

<?php include_partial('mail/mail_footer_fi');?> 
