Bună  <?php echo $user->getFirstName()?>,<br><br>

<?php if ($count == 1):?>
Voucherul tău pentru oferta <?php echo $company_offer->getTitle('ro');?> a fost emis!
<br><br>
Pentru a-l vedea click

<?php echo link_to('aici', 'profile/vouchers',array('absolute' => true));?>

sau – dacă linkul nu este activ, copiază linkul de mai jos în browser:
<?php elseif($count > 1):?>
Voucherele tale pentru oferta <?php echo $company_offer->getTitle('ro');?> au fost emise!
<br><br>
Pentru a le vedea click
<?php echo link_to('aici', 'profile/vouchers',array('absolute' => true));?>
 sau – dacă linkul nu este activ, copiază linkul de mai jos în browser:
<?php endif;?>
<br><br>
<?php echo url_for('profile/vouchers', true)?>

<br><br>
<?php if ($count == 1):?>
Dacă ești deja logat în contul getlokal.ro, vei putea să îți vezi voucherele imediat după ce accesezi linkul de mai sus.
<?php elseif($count > 1):?>
Dacă ești deja logat în contul getlokal.ro, vei putea să îți vezi voucherele imediat după ce accesezi linkul de mai sus.
<?php endif;?>
 Dacă nu, te rugăm să intri în cont și apoi în secțiunea „Voucherele mele” pentru a le vedea.<br>
Dacă ai vreo întrebare sau vreo nelămurire, te-așteptăm cu un mail la  <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>.<br><br>

Cu drag,<br>
Echipa getlokal.ro<br>
<br><br>
-----------------------------------------------
<br><br>
<?php $title_en= (($company_offer->getTitle('en'))? $company_offer->getTitle('en') : $company_offer->getTitle('ro'));?>
Hello <?php echo $user->getFirstName()?>,<br><br>

<?php if ($count == 1):?>
Your voucher for the <?php echo $title_en;?> offer was issued successfully. <br><br>
To view it click
<?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> or if the link is not active copy the URL below and put in the address field of your browser. <br>
<?php elseif($count > 1):?>
Your vouchers for the <?php echo $title_en;?> offer were issued successfully.
To view them click <?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?> or if the link is not active copy the URL below and put in the address field of your browser.  <br>
<?php endif;?>
<br>
<?php echo url_for('profile/vouchers',true)?>
<br><br>
If you're already logged in your getlokal.com account, you will be able to view your vouchers straight away after clicking on the link. If not, please log in your getlokal.com account and go to 'My Vouchers'.<br>
If you have any questions, please contact us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br>
<br>
Best Regards<br>
The getlokal.ro team

<?php include_partial('mail/mail_footer_ro');?>