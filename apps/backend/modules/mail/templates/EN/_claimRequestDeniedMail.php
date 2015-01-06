<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
Здравейте<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' г-жо': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' г-н': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Вашата заявка за администриране на <?php echo $company->getCompanyTitleByCulture('bg');?>, <?php echo $company->getDisplayAddress(); ?> в <a href="http://www.getlokal.com">www.getlokal.com</a> беше отхвърлена.
<br><br>
Обичайната ни практика е да проверяваме по телефона, дали лицето, заявило желанието си да управлява определено място е упълномощено да го направи
<br><br>
Най-вероятно, причината, поради която заявката е била отхвърлена е, че не сме успели да получим потвърждение, че можете да управлявате информацията за <?php echo $company->getCompanyTitleByCulture('bg');?> в getlokal.com.
<br><br>
Възможно е и отхвърлянето на заявката да се дължи на проблем със записа за <?php echo $company->getCompanyTitleByCulture('bg');?> в базата ни данни, за което се извиняваме. Ще се свържем с вас възможно най-скоро, за да коригираме проблема.
<br><br>
Ако имате допълнителни въпроси, моля пишете ни на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.
<br><br>
Екипът на getlokal.com
<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
Your Place Claim for  <?php echo $company->getCompanyTitleByCulture('en');?>, <?php echo $company->getDisplayAddress(); ?> on <a href="http://www.getlokal.com/en">www.getlokal.com</a> has been rejected.
<br><br>
We usually verify over the phone whether the person claiming a place is authorized to manage the business information.
<br><br>
The most likely reason why we rejected your claim is that we couldn’t gather sufficient information to prove your entitlement.
<br><br>
It is also possible that the rejection was due to problems with this record in our database for which we apologize. We will contact you as soon as we can to ensure your claim is assigned to the correct place.
<br><br>
If you have any further questions, please feel free to contact us at <a href="mailto:info@getlokal.com">info@getlokal.com</a>.
<br><br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>
