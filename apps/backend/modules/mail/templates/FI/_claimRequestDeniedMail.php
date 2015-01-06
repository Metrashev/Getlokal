<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
Hyvä<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Rouva': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Herra': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Sinun käyttöoikeuspyyntösi <?php echo $company->getCompanyTitleByCulture('fi');?>, <?php echo $company->getDisplayAddress(); ?> в <a href="http://www.getlokal.fi">www.getlokal.fi</a> беше отхвърлена.
<br><br>
Käytäntönämme on tarkistaa puhelimitse onko käyttöoikeuspyynnön jättänyt henkilö valtuutettu käsittelemään yrityksen tietoja.
<br><br>
Yleisin syy käyttöoikeuspyynnön hylkäämisen on, ettemme pystyneet todentamaan annettujen tietojenne oikeillisuutta.
<br><br>
On myös mahdollista että hylkäämisen syy johtuu tilapaisestä häiriöstä tietokannassamme. Otamme teihin yhteyttä mahdollisimman pian varmistaaksemme, että pyyntönne käsitellään asianmukaisesti.
<br><br>
Jos Sinulla on kysyttävää, ota yhteyttä <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.

<br><br>
Getlokal.fi tiimi!
<br><br>

-----------------------------------------------
<br><br>

<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
Your Place Claim for  <?php echo $company->getCompanyTitleByCulture('en');?>, <?php echo $company->getDisplayAddress(); ?> on <a href="http://www.getlokal.fi">www.getlokal.fi</a> has been rejected.
<br><br>
We usually verify over the phone whether the person claiming a place is authorized to manage the business information.
<br><br>
The most likely reason why we rejected your claim is that we couldn’t gather sufficient information to prove your entitlement.
<br><br>
It is also possible that the rejection was due to problems with this record in our database for which we apologize. We will contact you as soon as we can to ensure your claim is assigned to the correct place.
<br><br>
If you have any further questions, please feel free to contact us at <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.
<br><br>
The getlokal.fi team

<?php include_partial('mail/mail_footer_fi');?>
