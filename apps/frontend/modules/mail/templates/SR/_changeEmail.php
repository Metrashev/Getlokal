<br><br>
Zdravo<br>
Molimo kliknite na link ispod kako biste potvrdili svoju email adresu. Ukoliko link nije aktivan, molimo kopirajte ga i unesite u polje za pretragu u Vašem brouzeru. Vaša lozinka je ostala ista.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
Ovaj postupak će ponovo aktivirati Vaš nalog i moći čete pisati preporuke za vaše omiljene firme i mesta.<br>
Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
Getlokal.rs tim
<br><br>
-------------------------------------------------------------------
<br><br>
Hello<br>
Please click on the link below to confirm your new email address. If the link is not active please copy and paste it in the address bar. Your password remains the same.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
This will reactivate your account so you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Enjoy getlokal.rs!<br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>