<?php use_helper('Date','Frontend');
$pages = $list->getAllListPage();
?>
<li>
	<div class="tab-image">
<!-- 		<img src="http://lorempixel.com/150/100/" alt=""> -->
		<?php 
			if ($list->getImageId()):
				echo image_tag($list->getThumb(0),array('size'=>'150x100', 'alt'=>$list->getTitle() ));
			elseif (count($pages)):
				
				foreach ($pages as $kay => $company):
					if ($company->getCompanyPage()->getCompany()->getImageId() || $kay==count($pages)-1):
						echo image_tag($company->getCompanyPage()->getCompany()->getThumb(0),array('size'=>'150x100', 'alt'=> $list->getTitle() ));
						break;
					endif;
				endforeach;
			endif; ?>
	</div>
	<!-- tab-image -->

	<div class="tab-content">
		<h5>
			<i class="fa fa-unlock"></i><a class="tab-list-p" href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>"><?php echo $list->getTitle();?></a>
		</h5>
		<p>
			<?php echo __('by')?><span><?php echo $list->getUserProfile()->getLink(ESC_RAW); ?></span>
		</p>
		<span><em><?php echo truncate_text(html_entity_decode ($list->getDescription()), 230, '...', true) ?></em>
		</span>
	</div>
	<!-- tab-content -->
</li>
