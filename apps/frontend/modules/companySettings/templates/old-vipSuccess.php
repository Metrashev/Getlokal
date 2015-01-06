<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('Date');?>
<?php $culture = $sf_user->getCulture();?>
<div class="settings_content">
 
 
  
  <?php if(count($vips) > 0): ?>
     <?php echo __('Your company will appear in the VIP Positions module for 1 month (30 days) between the live and end dates of your advert. You can change the automatically set date by using the controls below.', null, 'company')?>
  
<?php foreach ($vips as $vip):?>
<?php if ($vip->getStartDate() && (strtotime($vip->getStartDate('Y-m-d')) <= strtotime(date('Y-m-d')))):?>
<?php echo __('Your company is already appearing in the VIP Positions module according to the dates you selected.', null, 'company');?>  (<b><?php echo format_date($vip->getStartDate(), 'dd MMM yyyy',$culture);?></b>)<br>
  <?php else:?>
 <?php $form = new VipForm (Doctrine_Core::getTable('AdCompany')->findOneById($vip->getId()));?>
<form  action="<?php echo url_for('companySettings/addVipDate?ad_id='.$vip->getId())?>" method="POST">
  <div class="form_box <?php echo $form['start_date']->hasError()? 'error': '' ?>">
      <?php echo $form['start_date']->renderLabel() ?>
      <?php echo $form['start_date']->render() ?>      
      <?php echo $form['start_date']->renderError() ?>
    </div>
 
 <?php echo $form->renderHiddenFields();?>
   
  <input type="submit" value="<?php echo  __('Save');?>" class="input_submit"/>
</form>
<?php endif;?>

<?php endforeach;?>
<?php endif;?>
</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function () { 
	$('.path_wrap').remove();
})
</script>