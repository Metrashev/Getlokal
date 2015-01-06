Információ a felhasználóról:<br>
<?php $position = $user_data['page_admin']['position'];?>
Keresztnév: <?php echo $profile->getFirstName();?><br>
Vezetéknév: <?php echo $profile->getLastName();?><br>
Nem: <?php echo $profile->getUserProfile()->getGender();?><br>
Születési dátum: <?php echo ($profile->getUserProfile()->getBirthdate() ? $profile->getUserProfile()->getBirthdate(): 'N/A');?><br><br>
Állás: <?php echo Social::$positionChoices[$position];?><br>
Helyzet: pending<br>
Először lép be: Igen<br>
getlokal profile url: <?php echo url_for('@user_page?username='.$profile->getUsername(), true) ?>
<br><br>
Céginformáció:<br>
<?php // $company = $pageAdmin->getCompanyPage()->getCompany();?><br>
Cég neve: <?php echo $company->getTitle(); ?><br>
Cég neve (Angolul): <?php echo $company->getCompanyTitleByCulture('en');?><br>
Cég helyzete:
<?php switch ($company->getStatus()):
case CompanyTable::VISIBLE:
	$status = 'látható(jóváhagyott)';
	break;
	case CompanyTable::NEW_PENDING:
	$status = 'Új (Várakozó)';
	break;
	case CompanyTable::INVISIBLE_NO_CLASS:
	$status = 'nem látható (NINCS besorolás)';
	break;
	case CompanyTable::INVISIBLE:
	$status = 'nem látható';
	break;
	case CompanyTable::REJECTED:
	$status = 'Visszautasított';
	break;
	endswitch;
	echo $status;
?> <br>
<?php if(isset($reg_no)):?><br>
New Company Reg. No: <?php echo $reg_no;?><br>
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