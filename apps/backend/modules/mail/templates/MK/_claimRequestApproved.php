<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? 'Почитувана г-а': (($pageAdmin->getUserProfile()->getGender() == 'm')? 'Почитуван г-дин': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,

<br /><br />
Го одобривме Вашето барање за администрирање на профилот и одсега <?php echo $company->getCompanyTitleByCulture('mk');?> е поврзана со Вашиот профил на <a href="http://www.getlokal.mk">www.getlokal.mk</a>.
<br /><br />
Кликнете на линкот подолу за да се најавите на Вашиот профил.
<br><br>
<a href="http://www.getlokal.mk/mk/login">http://www.getlokal.mk/mk/login</a><br><br>
Од Вашите подесувања кликнете на 'Мои Места' и внесете го Вашето корисничко име <?php echo $pageAdmin->getUsername();?> и лозинката која ја добивте за <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
Потоа ќе бидете во можност да поставувате слики, работно време и опис на <?php echo $company->getCompanyTitleByCulture('en');?> како и да одговарате на препораките. Ќе додаваме повеќе опции за компаниите да привлечат повеќе потрошувачи преку getlokal.mk и ќе Ве известиме за истите.

<br><br>
Ако имате прашања, слободно пишете ни на: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br />
<br />
Ви благодариме, уживајте во getlokal.mk! <br />
Тимот на getlokal.mk
<br><br><br>

-----------------------------------------------
<br><br>

Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,

<br /><br />
We approved your request and <?php echo $company->getCompanyTitleByCulture('en');?> is now linked to your profile on <a href="http://www.getlokal.mk/en">www.getlokal.mk</a>.
<br /><br />
Click on the link below and log into your account.
<br><br>
<a href="http://www.getlokal.mk/en/login">http://www.getlokal.mk/en/login</a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitleByCulture('en');?> as well as to respond to user reviews. We will be adding more options for companies to attract customers via getlokal.com and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br />
<br />
Thank you very much and enjoy getlokal.mk! <br />
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>
