<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content statistics">
  <h2 class="dotted"><?php  echo  __('Stats for ',null,'company') . link_to_company($company); ?></h2>
  <?php include_partial('statistics', array('company' => $company, 'month'=>$month)) ?>

</div>


<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function () { 
	$('.path_wrap').remove();
})
</script>