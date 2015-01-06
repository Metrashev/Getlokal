<p>Opinia ta despre <?php echo $company->getTitle() ?>, trimisă la <a href="http://www.getlokal.ro">www.getlokal.ro</a> a fost respinsă.
</p>
<p>Dacă vrei ca opinia ta despre <?php echo $company->getTitle() ?>, să fie publicată, redacteaz-o conform <a href="http://www.getlokal.ro/ro/page/terms-of-use">Condiţiilor de utilizare a serviciului "Opinii şi note"</a> a site-lui getlokal.</p>


<p>Dacă ai întrebări întrebări, nu ezita să iei legătura cu noi, la: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>.<br />
Mulţumim şi un surffing plăcut!<br />
Echipa getlokal.ro<br /></p>


<p>-----------------------------------------------</p>


<p>Your review for  <?php echo $company->getCompanyTitleByCulture('en')   ?> submitted via <a href="http://www.getlokal.ro">www.getlokal.ro</a> was rejected.

</p>
<p>If you would like your review for <?php echo $company->getCompanyTitleByCulture('en')   ?> to be published please edit it by following the <a href="http://www.getlokal.ro/ro/page/terms-of-use">Terms of Use of the getlokal "Rate and Review" service</a>.</p>



<p>If you have any questions, feel free to write to us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br />
Enjoy getlokal.ro!<br />
The getlokal.ro team
</p>

<?php include_partial('mail/mail_footer_ro');?>