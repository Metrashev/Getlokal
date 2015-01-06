
Welcome to getlokal.com<br>
Your getlokal account was deactivated successfully.
Please click on the link below to activate your account. If the link is not active please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Once you've activated your account you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>
