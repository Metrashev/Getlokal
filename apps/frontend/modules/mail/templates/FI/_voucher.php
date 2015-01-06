Hei <?php echo $user->getFirstName()?>,<br><br>

<?php if ($count == 1):?>
Kuponkisi <?php echo $company_offer->getTitle('bg');?> tarjoukseen on myönnetty onnistuneesti.
<br><br>
Avaa se klikkaamalla 

<?php echo link_to('tästä', 'profile/vouchers',array('absolute' => true));?>

 jos linkki ei toimi, kopio se hakukenttääsi.
<?php elseif($count > 1):?>
Kuponkisi <?php echo $company_offer->getTitle('bg');?> tarjoukseen on myönnetty onnistuneesti.
<br><br>
Avaa se klikkaamalla 
<?php echo link_to('tästä', 'profile/vouchers',array('absolute' => true));?>
 jos linkki ei toimi, kopio se hakukenttääsi.
<?php endif;?>
<br><br>
<?php echo url_for('profile/vouchers', true)?>

<br><br>
Jos olet jo kirjautunut getlokal.fi palveluun, voit avata kupongin klikkaamalla linkkiä. Muussa tapauksessa, ole hyvä ja kirjaudu sisään getlokal.fi palveluun ja mene 'Kupongit' osioon.<br>
Jos Sinulla on kysyttävää, ole hyvä ja kirjoita meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br><br>

Parhain Terveisin<br>
Getlokal.fi tiimi

<br><br>
-----------------------------------------------
<br><br>

<?php $title_en= (($company_offer->getTitle('en'))? $company_offer->getTitle('en') : $company_offer->getTitle('bg'));?>
Hello <?php echo $user->getFirstName()?>,<br><br>

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
If you're already logged in your getlokal.fi account, you will be able to view your vouchers straight away after clicking on the link. If not, please log in your getlokal.fi account and go to 'My Vouchers'.<br>
If you have any questions, please contact us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
<br>
Best Regards<br>
The getlokal.fi team
<br>
<?php include_partial('mail/mail_footer_fi');?>
