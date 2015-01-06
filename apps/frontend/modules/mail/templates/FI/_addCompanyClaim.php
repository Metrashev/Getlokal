Käyttäjän tiedot:<br>
<?php $position = $user_data['page_admin']['position'];?>
Etunimi: <?php echo $profile->getFirstName();?><br>
Sukunimi: <?php echo $profile->getLastName();?><br>
Sukupuoli: <?php echo $profile->getUserProfile()->getGender();?><br>
Syntymäaika: <?php echo ($profile->getUserProfile()->getBirthdate() ? $profile->getUserProfile()->getBirthdate(): 'N/A');?><br><br>
Positio: <?php echo Social::$positionChoices[$position];?><br>
Asema: pending<br>
Ensisijainen yhteyshenkilö: Kyllä<br>
getlokal profiili url: <?php echo url_for('@user_page?username='.$profile->getUsername(), true) ?>
<br><br>
Yrityksen tiedot:<br>
<?php // $company = $pageAdmin->getCompanyPage()->getCompany();?><br>
Yrityksen nimi: <?php echo $company->getTitle(); ?><br>
Yrityksen nimi (englanniksi): <?php echo $company->getCompanyTitleByCulture('en');?><br>
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
<?php if(isset($reg_no)):?><br>
Uuden yhtiön rekisteröinti numero: <?php echo $reg_no;?><br>
<?php endif;?>
getlokal url: <?php echo link_to_company($company, array('absolute' => true));?>

<br><br>
-----------------------------------------------
<br><br>

User Information:<br>
<?php $position = $user_data['page_admin']['position'];?>
First Name: <?php echo $profile->getFirstName();?><br>
Last Name: <?php echo $profile->getLastName();?><br>
Gender: <?php echo $profile->getUserProfile()->getGender();?><br>
Birthdate: <?php echo ($profile->getUserProfile()->getBirthdate() ? $profile->getUserProfile()->getBirthdate(): 'N/A');?><br><br>

Position: <?php echo Social::$positionChoices[$position];?><br>
Status: pending<br>
Is Primary Contact: Yes<br>

getlokal profile url: <?php echo url_for('@user_page?username='.$profile->getUsername(), true) ?>
<br><br>
Company Information:<br>
<?php // $company = $pageAdmin->getCompanyPage()->getCompany();?><br>
Company Name: <?php echo $company->getTitle(); ?><br>
Company Name (English): <?php echo $company->getCompanyTitleByCulture('en');?><br>
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
<?php if(isset($reg_no)):?><br>
New Company Reg. No: <?php echo $reg_no;?><br>
<?php endif;?>
getlokal url: <?php echo link_to_company($company, array('absolute' => true));?>