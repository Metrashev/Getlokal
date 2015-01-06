Здраво<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' г-жо': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' г-н': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Мислењето за Вашата компанија <?php echo $company->getCompanyTitleByCulture('bg');?> објавено
на <?php echo $date;?> од корисник на <a href="http://www.getlokal.mk/">www.getlokal.mk</a>
е деактивирано од нашиот модератор заради нарушување на <a href="http://www.getlokal.mk/mk/page/terms-of-use">Условите за користење</a>.
<br><br>
Сите мислења за <?php echo $company->getCompanyTitleByCulture('bg');?> можете да ги видите на:<br>
http://www.getlokal.mk/mk/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br><br>
Доколку сакате да одговорите на мислење напишано за Вашата компанија, логирајте се во профилот на Вашата компанија <a href="http://www.getlokal.mk/login/mk">http://www.getlokal.mk</a> и кликнете на опцијата 'Одговори' која се наоѓа до мислењето. Вашиот одговор ќе биде објавен од името на <?php echo $company->getCompanyTitleByCulture('bg');?>.
<br><br>
Ако имате било какво прашање, слободно пишете ни на <a href="mailto:macedonia@getlokal.com">macedinia@getlokal.com</a>.
<br><br>
Благодарност и пријатно сурфање!<br>
Тимот на getlokal.mk
<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
The review published about <?php echo $company->getCompanyTitleByCulture('en');?> on <?php echo $date;?> by a user of <a href="http://www.getlokal.mk/en">www.getlokal.mk</a>
was deactivated by one of our moderators as it violates the <a href="http://www.getlokal.nk/en/page/terms-of-use">Terms of Use</a>.
<br><br>
You can see all reviews for <?php echo $company->getCompanyTitleByCulture('en');?> at the address below:<br>
http://www.getlokal.mk/en/<?php echo $company->getCity()->getSlug().'/'.$company->getSlug()?>
<br><br>

If you would like to reply to a review that has been posted about your company, log into your company profile <a href="http://www.getlokal.mk/en/login">http://www.getlokal.mk</a> and click on 'Reply' next to the review. Your reply will be published on behalf of <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">info@getlokal.com</a>
<br><br>
Thank you very much and enjoy getlokal.mk <br>
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>