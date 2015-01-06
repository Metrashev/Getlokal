<?php use_helper('Link')?>
<?php $path = link_to_frontend('company', array('sf_culture'=>'sr', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>

<?php echo ($profile->getGender() == 'f')? 'Draga': (($profile->getGender() == 'm')? 'Dragi': 'Zdravo');?>, <?php echo $firstName;?><br><br>

Hvala vam! Mesto/firma (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitleByCulture('sr');?></a>) koje ste predložili je odobreno!
<br><br>
Sada možete pisati preporuke, objavljivati fotografije i podeliti svoje iskustvo sa ostalim korisnicima :)
<br><br>
Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
Getlokal.rs tim
<br><br>
-----------------------------------------------
<br><br>
<?php $path = link_to_frontend('company', array('sf_culture'=>'en', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Dear, <?php echo $firstName;?><br><br>
Thank you! The place (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitleByCulture('en');?></a>) you suggested to us was approved!
<br><br>
You can now review it, post pictures and share your experience with other people like you :)
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Enjoy getlokal.rs!<br>
The getlokal.rs team
