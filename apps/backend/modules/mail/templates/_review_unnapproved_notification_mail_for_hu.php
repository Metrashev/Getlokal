<p>A megjegyzésed <?php echo $company->getTitle() ?>-ról elküldött <a href="http://www.getlokal.hu">www.getlokal.hu</a>-nak vissza lett utasítva. 

</p>
<p>Ha akarod hogy a mejegyzésed <?php echo $company->getTitle() ?>-ról megjelenjék, szerkeszd  meg azt a <a href="http://www.getlokal.hu/hu/page/terms-of-use">getlokal "Vélemények és értékelések" szolgáltatás feltételeink megfelelően</a> </p> 


<p>Ha valami kérdésed van nyugodtan írjál nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com-címre</a>.<br>
Élvezz a getlokal.hu-ot!<br>
getlokal.hu csapata<br></p>


<p>-----------------------------------------------</p>


<p>Your review for  <?php echo $company->getTitleEn() ?> submitted via  <a href="http://www.getlokal.hu">www.getlokal.hu</a> was rejected.

</p>
<p>If you would like your review for <?php echo $company->getTitleEn() ?> to be published please edit it by following the <a href="http://www.getlokal.hu/en/page/terms-of-use">Terms of Use of the getlokal "Rate and Review" service</a>.</p> 



<p>If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Enjoy getlokal.hu!<br>
The getlokal.hu team
</p>

<?php include_partial('mail/mail_footer_hu');?> 