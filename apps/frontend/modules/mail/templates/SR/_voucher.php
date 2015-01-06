Zdravo <?php echo $name;?>,<br><br>

<?php if ($count == 1):?>
Vaučer za Ponudu '<?php echo $company_offer->getTitle('sr');?>' ti je uspešno izdat. 
<br><br>
Vaučer se može videti 

<?php echo link_to('ovde', 'profile/vouchers',array('absolute' => true));?> 
a ukoliko link nije aktivan, kopiraj url ispod i unesi u polje za pretragu u brouzeru. <br>

<?php elseif($count > 1):?>
Vaušeri za Ponudu '<?php echo $company_offer->getTitle('sr');?>' su uspešno izdati.
<br><br>
Vaučere možeš videti <?php echo link_to('ovde', 'profile/vouchers',array('absolute' => true));?> 
a ukoliko link nije aktivan, kopiraj url ispod i unesi u polje za pretragu u brouzeru.
<?php endif;?>
<br>
<?php echo url_for('profile/vouchers',true)?>

<br><br>
Za lakše korišćenje vaučera preuzmi getlokal aplikaciju na linku <a href="http://app.getlokal.com/?lang=sr">http://app.getlokal.com/?lang=sr</a>
<br><br>
Ukoliko ste ulogovani na svoj getlokal.rs nalog, moći ćete videti vaučere čim kliknete na link. 

Svoje vaučere možeš videti u sektoru 'Moji Vaučeri' na svom getlokal profilu.<br><br>
Ako imaš bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br><br>
Pozdrav,<br>
Getlokal.rs tim
<br><br>
-----------------------------------------------
<br><br>
<?php $title_en= (($company_offer->getTitle('en'))? $company_offer->getTitle('en') : $company_offer->getTitle('sr'));?>
Hello <?php echo $name?>,<br><br>

<?php if ($count == 1):?>
Your voucher for the offer '<?php echo $title_en;?>' was issued successfully. <br><br>
To view it click
<?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> or if the link is not active copy the URL below and put in the address field of your browser.<br>
<?php elseif($count > 1):?>
Your vouchers for the offer '<?php echo $title_en;?>' were issued successfully.
To view them click <?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> or if the link is not active copy the URL below and put in the address field of your browser.<br>
<?php endif;?>
<br>
<?php echo url_for('profile/vouchers',true)?>
<br><br>
Tip: download getlokal app for using vouchers easier <a href="http://app.getlokal.com/?lang=sr">http://app.getlokal.com/?lang=sr</a>
<br><br>
If you're already logged in your getlokal.rs account, you will be able to view your vouchers straight away after clicking on the link. If not, please log in yourgetlokal.rs account and go to 'My Vouchers'.<br><br>
If you have any questions, please contact us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
<br>
Best Regards<br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>