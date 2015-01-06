
<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Здравейте<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' г-жо': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' г-н': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Ние одобрихме вашата заявка и фирма <?php echo $company->getCompanyTitleByCulture('bg');?> е вече свързана с вашия профил в <a href="http://www.getlokal.com">www.getlokal.com</a>.
<br><br>
Кликнете на линка долу и влезете във вашия потребителски профил. <br>
<br><br>
<a href="http://www.getlokal.com/bg/login">http://www.getlokal.com/bg/login</a><br><br>
От меню 'Настройки' изберете 'Моите места' и въведете потребителско име <?php echo $pageAdmin->getUsername();?> и избраната от вас парола за <?php echo $company->getCompanyTitleByCulture('bg');?>.
<br><br>
По този начин ще можете да качвате снимки, работно време и описание на дейността на <?php echo $company->getCompanyTitleByCulture('bg');?>, както и да отговаряте на мнения. В най-скоро време ще пуснем и допълнителни опции за привличане на повече клиенти през getlokal.com, за които ще ви уведомим.
<br><br>
Ако имате въпроси, свържете с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>

Благодарим ви и ви пожелаваме приятно сърфиране!
Екипът на getlokal.com

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
We approved your request and <?php echo $company->getCompanyTitleByCulture('en');?> is now linked to your profile on <a href="http://www.getlokal.com/en">www.getlokal.com</a>.
<br><br>
Click on the link below and log into your account.
<br><br>
<a href="http://www.getlokal.com/en/login">http://www.getlokal.com/en/login</a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitleByCulture('en');?> as well as to respond to user reviews. We will be adding more options for companies to attract customers via getlokal.com and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.com! <br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>