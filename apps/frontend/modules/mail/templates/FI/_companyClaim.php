Käyttäjän tiedot:<br>
<?php $profile = $pageAdmin->getUserProfile();?>
Etunimi: <?php echo $profile->getSfGuardUser()->getFirstName();?><br>
Sukunimi: <?php echo $profile->getSfGuardUser()->getLastName();?><br>
Sukupuoli: <?php echo $profile->getGender();?><br>
Syntymäaika: <?php echo ($profile->getBirthdate() ? $profile->getBirthdate(): 'N/A');?><br><br>
Positio: <?php echo Social::$positionChoices[$pageAdmin->getPosition()];?><br>
Asema: <?php echo $pageAdmin->getStatus();?><br>
Ensisijainen yhteyshenkilö: <?php echo ($pageAdmin->getIsPrimary() ? 'Kyllä' : 'Ei');?><br>
getlokal profiili url: <?php echo url_for('@user_page?username='.$profile->getSfGuardUser()->getUsername(), true) ?>
<br><br>
Yrityksen tiedot:<br>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?><br>
Yrityksen nimi: <?php echo $company->getTitle(); ?><br>
Yrityksen nimi (englanniksi): <?php echo $company->getCompanyTitleByCulture('en'); //echo $company->getTitle(); ?><br>
Yhtiön tila:
<?php switch ($company->getStatus()):
case CompanyTable::VISIBLE:
	$status = 'Näkyvissä (hyväksytty)';
	break;
	case CompanyTable::NEW_PENDING:
	$status = 'Uusi (odottaa hyväksyntää)';
	break;
	case CompanyTable::INVISIBLE_NO_CLASS:
	$status = 'Näkymätön (Ei Luokiteltu)';
	break;
	case CompanyTable::INVISIBLE:
	$status = 'Näkymätön';
	break;
	case CompanyTable::REJECTED:
	$status = 'Hylätty';
	break;
	endswitch;
	echo $status;
?> <br>
<?php if(isset($new_registration_no)):?><br>
Uuden yhtiön rekisteröinti numero: <?php echo $new_registration_no;?><br>
<?php endif;?>
getlokal url: <?php echo link_to_company($company, array('absolute' => true));?>

<br><br>
-----------------------------------------------
<br><br>

User Information:<br>
<?php $profile = $pageAdmin->getUserProfile();?>
First Name: <?php echo $profile->getSfGuardUser()->getFirstName();?><br>
Last Name: <?php echo $profile->getSfGuardUser()->getLastName();?><br>
Gender: <?php echo $profile->getGender();?><br>
Birthdate: <?php echo ($profile->getBirthdate() ? $profile->getBirthdate(): 'N/A');?><br><br>
Position: <?php echo Social::$positionChoices[$pageAdmin->getPosition()];?><br>
Status: <?php echo $pageAdmin->getStatus();?><br>
Is Primary Contact: <?php echo ($pageAdmin->getIsPrimary() ? 'Yes' : 'No');?><br>
getlokal profile url: <?php echo url_for('@user_page?username='.$profile->getSfGuardUser()->getUsername(), true) ?>
<br><br>
Company Information:<br>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?><br>
Company Name: <?php echo $company->getTitle(); ?><br>
Company Name (English): <?php $title = $company->getCompanyTitleByCulture('en'); echo $title['title'] //echo $company->getTitle(); ?><br>

Company Status:
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
