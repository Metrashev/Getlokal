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
Company Name (English): <?php echo $company->getCompanyTitleByCulture('en') ; ?><br>
<?php if(isset($new_registration_no)):?><br>
New Company Reg. No: <?php echo $new_registration_no;?><br>
<?php endif;?>
getlokal url: <?php echo link_to_company($company, array('absolute' => true));?>
