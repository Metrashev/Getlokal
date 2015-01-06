<?php use_helper('Link')?>
<br><br>
<?php $path = link_to_frontend('company', array('sf_culture'=>'en', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Dear, <?php echo $profile->getFirstName();?><br>
Thank you! The place (<a href="<?php echo $path?>"><?php echo $company->getCompanyTitleByCulture('en');?></a>) you suggested to us was approved!
<br><br>
You can now review it, post pictures and share your experience with other people like you :)
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Enjoy getlokal.fi!<br>
The getlokal.fi team
