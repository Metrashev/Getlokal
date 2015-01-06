<?php use_helper('Link')?>
<?php $path = link_to_frontend('company', array('sf_culture'=>'ro', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
Dragă <?php echo $profile->getFirstName();?>,
<br><br>
În primul rând, mulţumim pentru sugestia de loc. După cum ştii, încercăm să dezvoltăm getlokal.ro într-un serviciu util pentru oricine, din orice oraş din România, aşa că apreciem timpul pe care l-ai petrecut ca să ajuţi comunitatea Getlokal!
<br><br>
În caz că aprobarea a durat un pic mai mult decât te aşteptai, ne cerem scuze. Un membru al echipei noastre trece prin toate sugestiile, verifică dacă locurile nu există deja şi adaugă, dacă e cazul, informaţii importante pe care e posibil să le fi ratat. E important pentru noi să păstrăm informaţia relevantă pe site, chiar dacă ne ia mai mult timp.
<br><br>
Locul pe care l-ai propus a fost aprobat de către echipa noastră şi este vizibil la adresa (<a href="<?php echo $path?>"><?php echo $path;?></a>)
<br><br>
Acum poţi să îţi scrii recomandarea sau să adaugi fotografii pentru (<?php echo $company->getCompanyTitleByCulture('ro');?>). Dacă eşti sau reprezinţi proprietarul locului, poţi revendica pagina locului, pentru a-ţi îmbunătăţi profilul online.
<br><br>
Bineînţeles, dacă mai ai sugestii de locuri, le aşteptăm (<a href="http://www.getlokal.ro/ro/d/company/addCompany">http://www.getlokal.ro/ro/d/company/addCompany</a>)

<br><br>
Nu rata ultimele noastre ştiri (<a href="http://www.getlokal.ro/ro/articles">http://www.getlokal.ro/ro/articles</a>)
<br><br>
Nu uita că am lansat aplicaţia de mobil, aşa că dacă ai iPhone sau Android, s-ar putea să fie interesant să citeşti despre ea <a href="http://app.getlokal.com/app/ro/">http://app.getlokal.com/app/ro/</a>
<br><br>
P.S. Dacă ai întrebări sau nelămuriri poți da reply acestui mail și îți răspundem cât putem de repede.<br><br>
Mulţumim şi enjoy getlokal.ro!<br>
Echipa getlokal.ro
<br><br>
-----------------------------------------------
<?php $path = link_to_frontend('company', array('sf_culture'=>'en', 'city'=>$company->getCity()->getSlug(), 'slug'=>$company->getSlug()));?>
<br><br>
Dear <?php echo $profile->getFirstName();?>,
<br><br>
Thank you for the place suggestion! As you know, we are trying to develop getlokal.ro into a service suited for everyone, in every city in Romania, so we really appreciate the time you spent helping the Getlokal community!
<br><br>
We are sorry if it took us more than a few hours to make it live. A member of our team is checking every suggestion to see if it's not already listed and to add, whenever the case, important information that you may have missed. We find it important to keep the information relevant, even if it takes a bit of extra time.
<br><br>
The place you suggested is now live on getlokal at this link (<a href="<?php echo $path?>"><?php echo $path;?></a>)<br>
You can now add a review or upload a picture for (<?php echo $company->getCompanyTitleByCulture('en');?>).<br><br>
If you are or represent the owner feel free to claim the place so you can enhance your profile with extra features.
<br><br>
Thanks and if you know more places that we don't have on the site, please let us know! <a href="http://www.getlokal.ro/en/d/company/addCompany">http://www.getlokal.ro/en/d/company/addCompany</a>
<br><br>
Don't miss our latest news (<a href="http://www.getlokal.ro/en/articles">http://www.getlokal.ro/en/articles</a>)
<br><br>
Dont forget about our mobile app - if you have an iPhone or an Android device, you might want to check this out: <a href="http://app.getlokal.com/app/ro/">http://app.getlokal.com/app/ro/</a><br>
P.S. Feel free to reply to this email if you have any questions. Bye, for now ;-)<br><br>
Thanks for the help and enjoy getlokal.ro!<br>
getlokal.ro team