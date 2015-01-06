<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
Почитуван <?php echo $pageAdmin->getUserProfile()->getFirstName(); ?>,
<br><br>
Вашето барање за администрација на <?php echo $company->getCompanyTitleByCulture('mk');?>, <?php echo $company->getDisplayAddress(); ?> на <a href="http://www.getlokal.mk">www.getlokal.mk</a> е одбиено.
<br><br>
Ние најчесто потврдуваме преку телефонски разговор дали лицето кое доставило барање за администрација е овластено за управување со бизнис инфомациите.
<br><br>
Најверојатно, причината поради која Вашето барање е одбиено е дека не сме собрале доволно информации за да го потврдиме Вашето овластување.
<br><br>
Исто така е возможно да сте одбиени поради проблеми со овој податок во нашата база на податоци поради што Ви се извинуваме. Ние ќе Ве контактираме што веднаш штом ќе бидеме во можност, со цел да се осигураме дали Вашето барање и доделено на вистинското место.
<br><br>
Доколку имате било какви понатамошни прашања, слободно контактирајте не на <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a>.
<br><br>
Со почит,
Тимот на getlokal.mk
<br><br><br>
-----------------------------------------------------------------------------
<br><br>
Dear <?php echo $pageAdmin->getUserProfile()->getFirstName(); ?>,
<br><br>
Your Place Claim for  <?php echo $company->getCompanyTitleByCulture('en');?>, <?php echo $company->getDisplayAddress(); ?> on <a href="http://www.getlokal.mk/en">www.getlokal.mk</a> has been rejected.
<br><br>
We usually verify over the phone whether the person claiming a place is authorized to manage the business information.
<br><br>
The most likely reason why we rejected your claim is that we couldn’t gather sufficient information to prove your entitlement.
<br><br>
It is also possible that the rejection was due to problems with this record in our database for which we apologize. We will contact you as soon as we can to ensure your claim is assigned to the correct place.
<br><br>
If you have any further questions, please feel free to contact us at <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a>.

<br><br>
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>