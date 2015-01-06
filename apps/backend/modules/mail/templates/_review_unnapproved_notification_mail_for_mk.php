<p>Твоето мислење за <?php echo $company->getTitle() ?> испратено на <a href="http://www.getlokal.mk">www.getlokal.mk</a> е
одбиено.
</p>
<p>Доколку сакаш твоето мислење за <?php echo $company->getTitle() ?> да биде објавено, ревидирај го согласно <a href="http://www.getlokal.mk/mk/page/terms-of-use">Условите за користење на услугата "Мислења и оцени"</a> на getlokal.</p>


<p>Ако имаш било какво прашање, слободно пиши ни на <a href="mailto:info@getlokal.com">macedonia@getlokal.com</a>.<br>
Благодарност и пријатно сурфање!<br>
Тимот на getlokal.mk<br></p>


<p>-----------------------------------------------</p>


<p>Your review for  <?php echo $company->getCompanyTitleByCulture('en')   ?> submitted via  <a href="http://www.getlokal.mk">www.getlokal.mk</a> was rejected.

</p>
<p>If you would like your review for <?php echo $company->getCompanyTitleByCulture('en')   ?> to be published please edit it by following the <a href="http://www.getlokal.mk/en/page/terms-of-use">Terms of Use of the getlokal "Rate and Review" service</a>.</p>



<p>If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
Enjoy getlokal.mk!<br>
The getlokal.mk team
</p>

<?php include_partial('mail/mail_footer_mk');?>