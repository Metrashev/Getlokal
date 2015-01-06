<?php use_helper('Link')?>
<?php $path = link_to_frontend('company', array('sf_culture'=>'bg', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Здравей, <?php echo $profile->getFirstName();?>,<br><br>
Благодарим! Мястото (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitleByCulture('bg');?></a>), което предложи в нашия сайт беше одобрено!
<br><br>
Вече можеш да напишеш ревюто си, да качиш снимки и да споделиш изживяванията си с други като теб :)
<br><br>
Ако имаш някакви въпроси, не се колебай да се свържеш с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
Благодарим и приятно сърфиране!<br>
Екипът на getlokal.com<br><br>

-----------------------------------------------
<br><br>
<?php $path = link_to_frontend('company', array('sf_culture'=>'en', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Dear, <?php echo $profile->getFirstName();?><br><br>
Thank you! The place (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitleByCulture('en');?></a>) you suggested to us was approved!
<br><br>
You can now review it, post pictures and share your experience with other people like you :)
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team
