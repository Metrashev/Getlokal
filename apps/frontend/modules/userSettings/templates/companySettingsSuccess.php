<?php include_partial('global/commonSlider'); ?>
<?php use_helper('Pagination') ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('My Places', null, 'user') ?></h1>
				</div>
			</div>	          
		</div>
		
		<div class="col-sm-4">
           <div class="section-categories">
                <!-- div class="categories-title">
                    
	            </div><!-- categories-title -->
                <?php include_partial('template'); ?>	            
	       </div>
		</div>
		 <div class="col-sm-8">
            <div class="content-default">
		    	<div class="row">
					<div class="default-container default-form-wrapper col-sm-12">
						<h2 class="form-title"><?php echo __('My Places', null, 'user') ?></h2>
						<!-- Form Start -->
						<div class="form-description">
							<?php include_partial('dashboard/protect_msg'); ?>
						</div>
						<?php if ($companies){  
									 $i = 1; 
							         foreach ($companies as $firm){ 
							         	//var_dump($sf_user);
							             if ($sf_user->hasFlash('formerror')){ 
							                 if (isset($company) && $company && ($company->getId() == $firm->getId())){ ?>
							                    <div class="flash_error">
							                        <?php if ($sf_user->hasFlash('formerror') == 'with_company'){ 
							                             echo sprintf(__("The username and/or password you entered for %s are invalid or you don't have enough credentials", null, 'form'), link_to_company($company)); 
							                         }else{ 
							                             echo __("The username and/or password you entered are invalid or you don't have enough credentials", null, 'form'); 
							                         } ?>
							                    </div>
							                <?php } 
							             } ?>
							            
							            <div class="settings_user_company styled-company" id="<?php echo $company->getId() ?>">
							                <div class="row">
								                <div class="col-md-10 company-info-part">
									                <div class="image"></div>
									                <div class="info">
										                <h2><?php echo $firm->getI18nTitle(); ?></h2>
										                <label class="address"><?php echo $firm->getDisplayAddress(); ?></label>
										            </div>
									            </div>
							
							                <?php if ($page_admin = $user->getUserProfile()->getIsCompanyAdmin($firm)){ 
								                     if (!($page_admin->getUsername())){ 
								                         if (isset($company) && $company && ($company->getId() == $firm->getId())){ 
								                                if (isset($form)){ ?> 
								                                <?php echo $form['_csrf_token']->render() ?>
								                                    <div class="custom-row toggle-row show-more js-form-open js-always-visible">
																		<div class="center-block txt-more">
																			<i class="fa fa-angle-double-down fa-lg"></i>
																			<span><?php echo __('Create Username and Password'); ?></span>
																			<i class="fa fa-angle-double-down fa-lg"></i>
																		</div>

																		<div class="center-block txt-less">
																			<i class="fa fa-angle-double-up fa-lg"></i>
																			<span><?php echo __('Create Username and Password'); ?></span>
																			<i class="fa fa-angle-double-up fa-lg"></i>
																		</div>
																	</div>
								                                 	<div class="login-form-toggle col-md-12">
								                                 		<div class="x-marks-the-spot"><i class="fa fa-times"></i></div>
								                                 	   <?php include_partial('companySettings/pageadmin_reg_old_form', array('form' => $form, 'without_address_title' => true)); 
								                                 	?> </div> <?php
								                                 }else{ ?>
								                                    <div class="custom-row toggle-row show-more js-form-open js-always-visible">
																		<div class="center-block txt-more">
																			<i class="fa fa-angle-double-down fa-lg"></i>
																			<span><?php echo __('Create Username and Password'); ?></span>
																			<i class="fa fa-angle-double-down fa-lg"></i>
																		</div>

																		<div class="center-block txt-less">
																			<i class="fa fa-angle-double-up fa-lg"></i>
																			<span><?php echo __('Create Username and Password'); ?></span>
																			<i class="fa fa-angle-double-up fa-lg"></i>
																		</div>
																	</div>
								                              		<div class="login-form-toggle col-md-12">
								                              			<div class="x-marks-the-spot"><i class="fa fa-times"></i></div>
								                                    	<?php include_partial('companySettings/pageadmin_reg_old_form', array('without_address_title' => true, 'form' => new PageAdminForm(Doctrine::getTable('PageAdmin')->findOnebyId($page_admin->getId())))); 
								                                 	?> </div> <?php
								                                 } 
								                         }else{ ?>
								                         	<div class="login-form-toggle col-md-12">
								            					<div class="x-marks-the-spot"><i class="fa fa-times"></i></div>
								                            	<?php include_partial('companySettings/pageadmin_reg_old_form', array('without_address_title' => true, 'form' => new PageAdminForm(Doctrine::getTable('PageAdmin')->findOnebyId($page_admin->getId())))); ?>
								                         	</div> 
								                            <div class="custom-row toggle-row show-more js-form-open js-always-visible">
																<div class="center-block txt-more">
																	<i class="fa fa-angle-double-down fa-lg"></i>
																	<span><?php echo __('Create Username and Password'); ?></span>
																	<i class="fa fa-angle-double-down fa-lg"></i>
																</div>

																<div class="center-block txt-less">
																	<i class="fa fa-angle-double-up fa-lg"></i>
																	<span><?php echo __('Create Username and Password'); ?></span>
																	<i class="fa fa-angle-double-up fa-lg"></i>
																</div>
															</div>
								                         <?php } 
								                         $i++; 
								                     }else{ ?>
								                        <a href="javascript:void(0)" class="col-md-2 default-btn success js-form-open"><?php echo __('Login'); ?></a>
								                        <div class="login-form-toggle col-md-12">
								                        	<div class="x-marks-the-spot"><i class="fa fa-times"></i></div>
								                        	<?php include_partial('companySettings/pageadmin_signin_form', array('without_address_title' => true, 'form' => new SigninPageAdminForm(null, array('company' => $firm)), 'company' => $firm, 'user' => $user));
								                        ?> </div> <?php
								                         //echo link_to(__('Forgot Password?', null,'user'),'userSettings/forgotPassword?slug='.$firm->getSlug(), 'class=forgot-pass');
								                      } 
								                 } ?>						
							              </div>
							          </div>
							  <?php }
						   }elseif($company){ 
					       			   echo $company->getI18nTitle(); 
					       }?>
					</div>
				</div>
            </div>
        </div>
</div>	
<script type="text/javascript">
function openSignUserForm(elem){
//	alert(1);
	$('.settings_user_company_form').slideToggle();
    /*$('.button_green').removeClass('formOpened');
    $(elem).addClass("formOpened");
    $('.settings_user_company_form').hide();
    $(elem).siblings().closest('.settings_user_company_form').slideToggle();
    $('.settings_user_company a#header_close').click(function(){
        $(".settings_user_company_form").slideUp('fast');
        $('.button_green').removeClass('formOpened');
    });*/ 
}

</script>
<style>
.settings_user_company {
    position: relative;
    margin-bottom: 25px;
    padding-bottom: 35px;
}
.dotted, .settings_content.statistics div.month_selector, .settings_content.statistics div.business_brief p {
    color: #404040;
    background: url('../images/gui/dot_down.png') repeat-x scroll left bottom transparent;
    margin-left: 10px;
    font-family: "Open Sans",Arial,Helvetica,sans-serif;
}
.settings_content .settings_user_company_form {
    position: absolute;
    right: 5px;
    top: 30px;
    border: 1px solid #01BABD;
    width: 270px;
    z-index: 999;
}
.settings_user_company_form {
    display: none;
    padding: 16px 25px 0px;
    color: #666;
    position: relative;
    background: none repeat scroll 0% 0% #FFF;
}
</style>