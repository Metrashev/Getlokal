<p>Твоето мнение за <?php echo $company->getTitle() ?> изпратено в <a href="http://www.getlokal.com">www.getlokal.com</a> беше 
отхвърлено.
</p>
<p>Ако искаш мнението ти за <?php echo $company->getTitle() ?> да бъде публикувано, редактирай го съобразно <a href="http://www.getlokal.com/bg/page/terms-of-use">Условията за ползване на услугата "Мнения и оценки"</a> на getlokal.</p> 


<p>Ако имаш някакви въпроси, не се колебай да се свържеш с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
Благодарим и приятно сърфиране!<br>
Екипът на getlokal.com<br></p>


<p>-----------------------------------------------</p>


<p>Your review for  <?php echo $company->getCompanyTitleByCulture('en') ?> submitted via  <a href="http://www.getlokal.com">www.getlokal.com</a> was rejected.

</p>
<p>If you would like your review for <?php echo $company->getCompanyTitleByCulture('en')   ?> to be published please edit it by following the <a href="http://www.getlokal.com/en/page/terms-of-use">Terms of Use of the getlokal "Rate and Review" service</a>.</p> 



<p>If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team
</p>

<?php include_partial('mail/mail_footer_bg');?> 