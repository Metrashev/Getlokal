Szervusz <?php echo $user->getFirstName()?>,<br><br>

<?php if ($count == 1):?>
Az utalványod <?php echo $company_offer->getTitle('hu');?> ajánlatra sikeresen lett kiadva.
<br><br>
Hogy megnézhessd kattints

<?php echo link_to('itt', 'profile/vouchers',array('absolute' => true));?>-re

 vagy ha a link nem aktiv másold le a lejjebb levő URL-t és helyezzd be a böngésződ címmezőjébe.
<?php elseif($count > 1):?>
Az utalványaid <?php echo $company_offer->getTitle('hu');?> ajánlatra sikeresen lettek kiadva.
<br><br>
Hogy megnézhessd kattints
<?php echo link_to('itt', 'profile/vouchers',array('absolute' => true));?>-re
 vagy ha a link nem aktiv másold le a lejjebb levő URL-t és helyezzd be a böngésződ  a címmezőjébe.
<?php endif;?>
<br><br>
<?php echo url_for('profile/vouchers', true)?>

<br><br>
<?php if ($count == 1):?>
Ha már benne vagy a getlokal.hu profilodban közvetlenül megnézheted az utalványodat ha kattintasz a linkre. 
<?php elseif($count > 1):?>
Ha már benne vagy a getlokal.hu profilodban közvetlenül megnézheted az utalványodat/aidat.
<?php endif;?> Ha nem vagy benne, lépjel be a profilodba getlokal.hu-ban és menjél 'Az én utalványaim'-ra.<br>
Ha bármilyen kérdésed lenne, nyugodtan írjál nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com címre.</a>.<br><br>

Üdvözlettel<br>
getlokal.hu csapata<br>
<br><br>
-----------------------------------------------
<br><br>
<?php $title_en= (($company_offer->getTitle('en'))? $company_offer->getTitle('en') : $company_offer->getTitle('en'));?>
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
If you're already logged in your getlokal.hu account, you will be able to view your vouchers straight away after clicking on the link. If not, please log in your getlokal.hu account and go to 'My Vouchers'.<br>
If you have any questions, please contact us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
<br>
Best Regards<br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?>