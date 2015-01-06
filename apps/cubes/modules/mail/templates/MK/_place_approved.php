<?php use_helper('Link')?>
<?php $path = link_to_frontend('company', array('sf_culture'=>'mk', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Здраво, <?php echo $profile->getFirstName();?>,<br><br>
Ти благодариме! Местото (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitleByCulture('mk');?></a>), кое го предложи на нашиот сајт е одобрено!
<br>

<br>Сега можеш да напишеш препораки, да прикачуваш слики и да ги споделиш твоите искуства со другите како тебе :)
<br>

<br>

Доколку имате било какви прашања, Ве молиме контактирајте не на <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a>.<br>
Со почит,<br>
Тимот на getlokal.mk<br><br>
-----------------------------------------------
<br><br>
<?php $path = link_to_frontend('company', array('sf_culture'=>'en', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Dear, <?php echo $profile->getFirstName();?><br><br>
Thank you! The place (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitleByCulture('en');?></a>) you suggested to us was approved!
<br><br>
You can now review it, post pictures and share your experience with other people like you :)
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team
