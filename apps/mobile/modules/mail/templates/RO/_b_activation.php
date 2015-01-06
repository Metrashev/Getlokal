Bine ai venit pe getlokal!
<br /><br />
Te rugăm să dai click pe linkul de mai jos pentru a confirma înregistrarea. Dacă linkul nu e activ, te rugăm să îl copiezi în browser.
<br /><br />
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?>
<br /><br />
După ce ai confirmat înregistrarea, log in, găsește-ți compania și revendic-o!
<br /><br />
Pentru orice întrebări, nu ezita să iei legătura cu noi, la
<a href="mailto:romania@getlokal.com">romania@getlokal.com</a> sau pe
<a href="http://facebook.com/getlokal.ro">Facebook</a> şi
<a href="http://twitter.com/getlokalized">Twitter</a>!
<br /><br />
Bucură-te de beneficiile pe care le are compania ta pe getlokal.ro!<br />
Echipa getlokal.ro<br />
<br />
<br />
-------------------------------------------------------------------
<br /><br />
Hello and welcome to getlokal.ro!<br /><br />
Please click on the link below to confirm your registration. If the link is not active, please copy and paste it in the address bar. <br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br /><br />
Once you've confirmed your registration, please log in, find your place and claim it!<br />
<br />
If you have any questions, write to us at:
<a href="mailto:romania@getlokal.com">romania@getlokal.com</a> or connect with us on
<a href="http://facebook.com/getlokal.ro">Facebook</a> and
<a href="http://twitter.com/getlokalized">Twitter</a>!
<br /><br />
Enjoy the benefits your business will get at getlokal.com!<br />
The getlokal.ro team

<?php include_partial('mail/mail_footer_ro');?>