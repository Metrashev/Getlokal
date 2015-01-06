Здравей <?php echo $user->getFirstName()?>,<br><br>

<?php if ($count == 1):?>
Твоят ваучер за офертата <?php echo $company_offer->getTitle('bg');?> беше издаден успешно.
<br><br>
За да го видиш, натисни

<?php echo link_to('тук', 'profile/vouchers',array('absolute' => true));?>

 или ако линка не е активен, сложи УРЛ-а по-долу в адресното поле на твоя браузер.
<?php elseif($count > 1):?>
Твоите ваучери за офертата <?php echo $company_offer->getTitle('bg');?> бяха издадени успешно.
<br><br>
За да ги видиш, натисни
<?php echo link_to('тук', 'profile/vouchers',array('absolute' => true));?>
 или ако линка не е активен, сложи УРЛ-а по-долу в адресното поле на твоя браузер.
<?php endif;?>
<br><br>
<?php echo url_for('profile/vouchers', true)?>

<br><br>
<?php if ($count == 1):?>
Ако си вече логнат в профила си в getlokal.com ще можеш директно да видиш твоят ваучер.
<?php elseif($count > 1):?>
Ако си вече логнат в профила си в getlokal.com ще можеш директно да видиш твоят(ите) ваучер(и).
<?php endif;?> В случай, че не си логнат, влез в профила си в getlokal.com и отиди на 'Моите ваучери'.<br>
Ако имаш въпроси, свържи се с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br><br>

Поздрави<br>
Екипът на getlokal.com<br>
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
If you're already logged in your getlokal.com account, you will be able to view your vouchers straight away after clicking on the link. If not, please log in your getlokal.com account and go to 'My Vouchers'.<br>
If you have any questions, please contact us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
<br>
Best Regards<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>