<?php use_helper('jQuery'); ?>
<div class="form_box">
<?php echo $form['orderclass'][$num]['sector_id']->renderLabel()?>
 <?php echo $form['orderclass'][$num]['sector_id']->render(array(
		'onchange'=>jq_remote_function(array(
  		  'update'=>'classification_id'. $num , //dom id
  		  'url'=>'companySettings/changeClassification?slug='.$company->getSlug(), //the action to be called
  		  'method'=>'get',
  		  'with'=>"'sector_id=' + this.options[this.selectedIndex].value+'&embedded_index='+".$num,
          'complete'=>"$('#classification_id". $num ."').show();",
		))
  	     )) ?>
</div>
 <div class="form_box" id="classification_id<?php echo  $num;?>" style="display:none"> 	
 <?php echo $form['orderclass'][$num]['classification_id']->renderLabel()?>     
<?php echo $form['orderclass'][$num]['classification_id']->render()?>
</div>
<?php $next =$num+1;?>

<?php $classifications_count= count($company->getCompanyClassification());?>
<?php $ads_count=$company->getActivePPPService(true);?>	

<?php  if (($ads_count 
 && ($classifications_count) < (($ads_count * AdServiceTable::CLASSIFICATIONS_COUNT)+CompanyTable::MAX_CLASSIFICATION_COUNT)
 && ($next) <= (($ads_count * AdServiceTable::CLASSIFICATIONS_COUNT)+CompanyTable::MAX_CLASSIFICATION_COUNT)
 ) or (!$ads_count && $next <= CompanyTable::MAX_CLASSIFICATION_COUNT )):?>

 
<div class="" id="classification_id_<?php echo $next;?>">
                   <a class="delete_link"><?php echo __('cancel', null, 'company')?></a>


					<?php  echo  jq_link_to_remote('<span>'.__('Add', null, 'company').'</span>', array(
                    	'update' => 'classification_id_'.$next,
                        'url'    => 'companySettings/addClassificationForm?num='.$next.'&slug='.$company->getSlug(),
					    
                        'onclick'=>'return true'
					));?>  
				</div>
                    <?php endif;?>

<script type="text/javascript">
    $(function(){
        $('div.add_classification_link a span').ready(function() {
            $('.delete_link').css('right', $('div.add_classification_link a span').outerWidth()+42);
            
        });
        
        $('.delete_link').live('click', function(){
            $('.add_classification_link .form_box').remove();
            $('.add_classification_link > div').css('paddingBottom', '20px')
   
            var href = "<a href=\"#\" onclick=\""+ $('input[name="hiddenLink"]').val() +"\"><?php echo __('Add new classification', null, 'company') ?></a>";
             $('.add_classification_link .additional_info_gray_bg .form_wrap').html(href);
        });
    });
</script>