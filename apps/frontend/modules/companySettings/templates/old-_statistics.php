<?php use_helper('Date');?>
<?php $culture = $sf_user->getCulture();?>
<?php if (!$month):?>
<div class="user_notifications" id="user_notifications">


<?php endif;?>
  <div class="business_notif_content">

   <!--  <div class="business_brief_top">
      <p>
        <b>VIP Profile</b><br/>
        Subscribe till 31.05.2012<br/>
        <a href="#">Renew your subsribution »</a>
      </p>
      <p>
        <b>VIP Profile</b><br/>
        Subscribe till 31.05.2012<br/>
        <a href="#">Renew your subsribution »</a>
      </p>
      <div class="clear"></div>
    </div> -->
    <div class="month_selector">
	    <?php $get_month = ($month ? $month : date('Y-m').'-01');?>
		
	    <?php if ($statsa = $company->getPrevMonths(true)):?>
			<select id="stats">
				<?php foreach ($statsa as $key => $val):?> 
					<option value ="<?php echo $key; ?>" <?php echo ($get_month == $key ? ' selected="selected"' : '')?>><?php echo format_date($val, 'MMM yyyy',$culture);?></option>
				<?php endforeach;?>
		   	</select>
                <label for="stats"> <?php echo format_date($get_month, 'MMM yyyy',$culture);?></label>
		   	<script>
			$('select').change(function() {
			    $.post("<?php url_for('companySettings/statistics?slug='.$company->getSlug()) ?>", {with_month: $(this).val()}, function(data) {
			        $('#user_notifications').html(data);
			    });
			});
			
			</script>
		<?php endif;?>
   	</div>
   	
   	
    <?php if (!$month or $month == date('Y-m').'-01'):?>
    <div class="business_brief">
     <p><?php echo __('Rating', null, 'company');?></p>
      <b><?php echo $company->getAverageRating();?></b>
    </div>
    <div class="business_brief">
     <p><?php echo __('Reviews')?> </p>
      <b><?php echo $company->getNumberOfReviews()?></b>
    </div>
    <?php endif;?>
    <?php if ($company->getStatsPerMonth($get_month)):?>    
    <?php $stats = $company->getStatsPerMonth($get_month);?>
    <?php foreach ($stats as $key =>$val):?>
    <?php switch ($key):
        case 1:
            $string ='Views in search';
            break;
	case 2:
            $string ='Company Page Visits';
            break;
	case 3:
            $string ='Clicks to website';
            break;
	case 4:
            $string ='Clicks to Facebook page';
            break;
	case 5:
            $string ='Sent Emails';
            break;
        /*
         * 
        case 6:
            $string ='Visits to Review Page';
            break;
        case 7:
            $string ='Detailed Map Views';
            break;
        case 8:
            $string ='Working Hours Views';
            break;
        case 9:
            $string = 'Detailed Description Views';
            break;
        case 10:
            $string ='Visits to Gallery page';
            break;
        case 11:
            $string ='Number of times videos visited';
            break;
        case 12:
            $string ='Number of times videos played';
            break;
         * 
         */
        case 13:
            $string ='Views in search';
            break;
        case 14:
            $string ='Clicks to Twitter page';
            break;
        case 15:
            $string ='Clicks to Foursquare page';
            break;
        case 16:
            $string ='Clicks to Google+ page';
            break;
        case 17:
            $string ='Clicks to Yellow Pages page';
            break;
	endswitch;?>

	
	<?php if ($key != sfConfig::get('app_log_actions_company_show_category')
	&& $key != sfConfig::get('app_log_actions_company_show_search')):?>
     <div class="business_brief">
     <p><?php echo  __($string,null,'company') ?></p>
     <b><?php echo $val;?></b>
     </div>
     <?php else:?>
      <?php if ($key == sfConfig::get('app_log_actions_company_show_category') && !isset($stats[sfConfig::get('app_log_actions_company_show_search')]) ):?>
         <div class="business_brief">
         <p><?php echo  __($string,null,'company'); ?></p>
         <b><?php echo $val;?></b>
         </div>
        <?php elseif ($key == sfConfig::get('app_log_actions_company_show_search')):?>
          <div class="business_brief">
          <p><?php echo  __($string,null,'company'); ?></p>
     
        <?php if(isset($stats[sfConfig::get('app_log_actions_company_show_category')])):?>
          
        <b><?php echo $val + $stats[sfConfig::get('app_log_actions_company_show_category')];?></b>
      
        <?php else:?>
           <b><?php echo $val;?></b>
         <?php endif;?>
        
        </div>
       <?php endif;?>  
      
      
      <?php endif;?>
    <?php endforeach;?>
   <?php endif;?>
    <div class="clear"></div>
  </div>
<?php if (!$month):?>
</div>
<?php endif;?>