Zdravo <?php echo $name;?>,<br><br>

<?php if ($count == 1):?>
Vaučer za <?php echo $company_offer->getTitle('sr');?> ponudu je iuspešno izdat. 
<br><br>
Da biste ga videli kliknite ovde

<?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> 
Ukoliko link nije aktivan, molimo kopirajte ga i unesite u polje za pretragu u Vašem brouzeru. <br>
<?php elseif($count > 1):?>
Vaušeri za <?php echo $company_offer->getTitle('sr');?> ponudu su uspešno izdati.
<br><br>
Da biste ih videli kliknite ovde <?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> 
Ukoliko link nije aktivan, molimo kopirajte ga i unesite u polje za pretragu u Vašem brouzeru.
<?php endif;?>
<br>
<?php echo url_for('profile/vouchers',true)?>

<br><br>
Ukoliko ste ulogovani na svoj getlokal.rs nalog, moći ćete videti vaučere čim kliknete na link. 

U suprotnom, molimo ulogujte se na svoj getlokal.rs nalog i idite u sektor 'Moji Vaučeri'.<br>
Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
Getlokal.rs tim
<br><br>
-----------------------------------------------
<br><br>
<?php $title_en= (($company_offer->getTitle('en'))? $company_offer->getTitle('en') : $company_offer->getTitle('sr'));?>
Hello <?php echo $name?>,<br><br>

<?php if ($count == 1):?>
Your voucher for the <?php echo $title_en;?> deal was issued successfully. <br><br>
To view it click
<?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> or if the link is not active copy the URL below and put in the address field of your browser. <br>
<?php elseif($count > 1):?>
Your vouchers for the <?php echo $title_en;?> deal were issued successfully.
To view them click <?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> or if the link is not active copy the URL below and put in the address field of your browser.  <br>
<?php endif;?>
<br>
<?php echo url_for('profile/vouchers',true)?>
<br><br>
If you're already logged in your getlokal.rs account, you will be able to view your vouchers straight away after clicking on the link. If not, please log in your getlokal.rs account and go to 'My Vouchers'.<br>
If you have any questions, please contact us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
<br>
Best Regards<br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>
