Здраво <?php echo $user->getFirstName()?>,<br><br>

<?php if ($count == 1):?>
Твојот ваучер за понудата <?php echo $company_offer->getTitle('bg');?> е успешно издаден.
<br><br>
За да го видиш, кликни

<?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?>

. Доколку линкот не е активен, можеш да го ископираш и поставиш во полето за адреса во пребарувачот.
<?php elseif($count > 1):?>
Твоите ваучери за понудата <?php echo $company_offer->getTitle('bg');?> се успешно издадени.
<br><br>
За да ги видиш, кликни
<?php echo link_to('here', 'profile/vouchers',array('absolute' => true));?>
. Доколку линкот не е активен, можеш да го ископираш и поставиш во полето за адреса во пребарувачот.
<?php endif;?>
<br><br>
<?php echo url_for('profile/vouchers', true)?>

<br><br>
<?php if ($count == 1):?>
Ако си веќе логиран/а во својот профил на getlokal.mk ќе можеш директно да го видиш ваучерот.
<?php elseif($count > 1):?>
Ако си веќе логиран/а во својот профил на getlokal.mk ќе можеш директно да ги видиш ваучерите.
<?php endif;?> Во случај да не си логиран/а, логирај се и потоа отиди во 'Мои ваучери'.<br>
Ако имаш било какво прашање, слободно пиши ни на <a href="mailto:"></a>.<br><br>

Поздрав,<br>
Тимот на getlokal.mk<br>
<br><br>
-----------------------------------------------
<br><br>
<?php $title_en= (($company_offer->getTitle('en'))? $company_offer->getTitle('en') : $company_offer->getTitle('bg'));?>
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
If you're already logged in your getlokal.mk account, you will be able to view your vouchers straight away after clicking on the link. If not, please log in your getlokal.mk account and go to 'My Vouchers'.<br>
If you have any questions, please contact us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
<br>
Best Regards<br>
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>