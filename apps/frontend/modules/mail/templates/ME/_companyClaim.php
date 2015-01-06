Informacije o korisniku:<br>
<?php $profile = $pageAdmin->getUserProfile();?>
Ime: <?php echo $profile->getSfGuardUser()->getFirstName();?><br>
Prezime: <?php echo $profile->getSfGuardUser()->getLastName();?><br>
Pol: <?php echo $profile->getGender();?><br>
Datum roðenja: <?php echo ($profile->getBirthdate() ? $profile->getBirthdate(): 'N/A');?><br><br>
Pozicija: <?php echo Social::$positionChoices[$pageAdmin->getPosition()];?><br>
Status: <?php echo $pageAdmin->getStatus();?><br>
Kontakt osoba: <?php echo ($pageAdmin->getIsPrimary() ? 'Yes' : 'No');?><br>
Link (URL) getlokal profila : <?php echo url_for('@user_page?username='.$profile->getSfGuardUser()->getUsername(), true) ?>
<br><br>
Informacije o mjestu/firmi:<br>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?><br>
Naziv mjesta/firme: <?php echo $company->getTitle(); ?><br>
Naziv mjesta/firme (Engleski): <?php echo $company->getCompanyTitleByCulture('en'); ?><br>
Status mjesta/firme:
<?php switch ($company->getStatus()):
case CompanyTable::VISIBLE:
	$status = 'visible (approved)';
	break;
	case CompanyTable::NEW_PENDING:
	$status = 'New (Pending)';
	break;
	case CompanyTable::INVISIBLE_NO_CLASS:
	$status = 'invisible (NO Classification)';
	break;
	case CompanyTable::INVISIBLE:
	$status = 'invisible';
	break;
	case CompanyTable::REJECTED:
	$status = 'Rejected';
	break;
	endswitch;
	echo $status;
?> <br>
<?php if(isset($new_registration_no)):?><br>
New Company Reg. No: <?php echo $new_registration_no;?><br>
<?php endif;?>
getlokal url: <?php echo link_to_company($company, array('absolute' => true));?>
