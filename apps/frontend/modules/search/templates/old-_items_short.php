<?php use_helper('Pagination','jQuery');?>
<?php if($pager->getNbResults() > 0): ?>
  <?php foreach ($pager->getResults() as $company):?><p>
    <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" title="<?php echo $company->getCompanyTitle() ?>">
      <?php echo $company->getCompanyTitle() ?>
    </a><br />
      <?php echo $company->getDisplayAddress() ?><br />    
   </p>
  <?php endforeach;?>
  
  
  
  <?php if ($pager->haveToPaginate()): ?>
<div class="clear"></div>

<div class="pagging">
<?php $baseurl ='search/searchByNameAndCity?name='. $name. '&city_id='. $city_id ;?>
 <?php if ($pager->getPage() != 1 && $pager->getPage() > 3):?>
<?php  echo  jq_link_to_remote('<span>'.__(' &laquo;').'</span>', array(
                                  'update' => 'data',
                                  'url'    => $baseurl.'&page=' . $pager->getFirstPage(),
                                        'onclick'=>'return true'
                                        ));?>
   
   <?php  echo  jq_link_to_remote('<span>'.__(' &lsaquo;').'</span>', array(
                                  'update' => 'data',
                                  'url'    =>$baseurl.'&page=' . $pager->getPreviousPage(),
                                        'onclick'=>'return true'
                                        ));?>   
                                        <?php endif;?>                                

 <?php ?>
<?php $links = $pager->getLinks(); foreach ($links as $page): ?>
  <?php echo ($page == $pager->getPage()) ? $page :

jq_link_to_remote('<span>'.$page.'</span>', array(
                                  'update' => 'data',
                                  'url'    => $baseurl.'&page=' . $page,
                                        'onclick'=>'return true'
                                        ))
  
  ?>

<?php endforeach ?>
 <?php if ($page != $pager->getLastPage()): ?>
<?php  echo  jq_link_to_remote('<span>'.__(' &rsaquo;').'</span>', array(
                                  'update' => 'data',
                                  'url'    => $baseurl.'&page=' . $pager->getNextPage(),
                                        'onclick'=>'return true'
                                        ));?>
   
   <?php  echo  jq_link_to_remote('<span>'.__(' &raquo;').'</span>', array(
                                  'update' => 'data',
                                  'url'    => $baseurl.'&page=' . $pager->getLastPage(),
                                        'onclick'=>'return true'
                                        ));?> 
<?php endif;?>

</div>

<?php endif; ?> 
 <a href="javascript:void(0)" id="header_close"></a> 

<?php endif;?> 

<script type="text/javascript">
	$(document).ready(function() {
		$('#header_close').click(function() {
			$('#data').toggle('fast');
		});
	});
</script>
