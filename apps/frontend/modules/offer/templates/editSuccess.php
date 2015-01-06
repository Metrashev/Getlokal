<div class="settings_content">
</div>

<?php
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
?>

<div class="container set-over-slider">
    <div class="row"> 
        <div class="container">
            <div class="row">
                <?php include_partial('companySettings/topMenu', $params); ?> 
            </div>
        </div>            
    </div>    
    <div class="col-sm-4">
        <div class="section-categories">
            <?php include_partial('companySettings/rightMenu', $params); ?>             
        </div>
    </div>
    <div class="col-sm-8">
        <div class="content-default">
        	<div class="row">
                <div class="default-container default-form-wrapper col-sm-12">
                    <div class="col-sm-12">
                        <?php include_partial('companySettings/tabsMenu', $params); ?>     
                    </div>
                    <h2 class="form-title"><?php echo __('Edit Offer', null, 'offer') ?></h2>
					<?php 
						if ($company_offer){ 
					        include_partial('form', array(
					            'form' => $form, 
					            'company' => $company,
					            'company_offer' => $company_offer,
					            'active'=> isset($active) && $active == 1 ? 1 : null
					        )); 
				    	}
				    ?>
				</div>
            </div>
        </div>
    </div>
</div>
