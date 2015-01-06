<?php //var_dump($sf_user->getCredentials()->getRawValue()); exit(); ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php //use_javascripts_for_form($form) ?>

 <?php if($sf_user->getFlash('newsuccess')):?>
    <div class="flash_success">
      <?php echo  __($sf_user->getFlash('newsuccess'),null,'article') ?>
      <a></a>
    </div>
 <?php endif;?>
 <?php if($sf_user->getFlash('newerror')):?>
    <div class="flash_error">
      <?php echo  __($sf_user->getFlash('newerror'),null,'article') ?>
    </div>
 <?php endif;?>
 <?php if($sf_user->getFlash('slug_culture_error')):?>
    <div class="flash_error">
      <?php echo  __($sf_user->getFlash('slug_culture_error'),null,'article') ?>
    </div>
 <?php endif;?>

  <?php if($sf_user->getFlash('slug_en_error')):?>
    <div class="flash_error">
      <?php echo  __($sf_user->getFlash('slug_en_error'),null,'article') ?>
    </div>
 <?php endif;?>

  <?php if($global_errors = $form->getGlobalErrors()):?>
     <?php foreach($global_errors as $er):?>
    <div class="flash_error">
      <?php echo $er->getMessage();?>
    </div>
    <?php endforeach;?>
 <?php endif;?>

<div class="article_form_wrap">
	<form id="articleForm" action="<?php echo url_for('article/'.($form->getObject()->isNew() ? 'create' : 'edit').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<?php $lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');   ?>
		<?php $tab_lng=sfConfig::get('app_cultures_en_'.$lng);?>
		<div class="standard_tabs_wrap">
			<div class="standard_tabs_top">
				<a href="#tab_0" class="current" href="javascript:void(0);"><?php echo __($tab_lng, null, 'company')?></a>
				<a href="#tab_1" href="javascript:void(0);"><?php echo __('English')?></a>
			</div>
			<div class="standard_tabs_in">
				<div id="tab_0" class="article_tab_in">
					<div class="form_box form_label_inline<?php if( $form[$lng]['title']->hasError()):?> error<?php endif;?> ">
						<?php echo $form[$lng]['title']->renderLabel()?><span class="pink">*</span>
						<?php echo $form[$lng]['title'] ?>
						<?php echo $form[$lng]['title']->renderError()?>
					</div>
					<div class="form_box form_label_inline<?php if( $form[$lng]['content']->hasError()):?> error<?php endif;?>">
						<?php echo $form[$lng]['content']->renderLabel()?><span class="pink">*</span>
						<?php echo $form[$lng]['content'] ?>
						<?php echo $form[$lng]['content']->renderError()?>
					</div>
					<div class="form_box<?php if( $form[$lng]['quotation']->hasError()):?> error<?php endif;?>">
						<?php echo $form[$lng]['quotation']->renderLabel()?>
						<?php echo $form[$lng]['quotation'] ?>
						<?php echo $form[$lng]['quotation']->renderError()?>
						<?php echo __('Copy this code and position it where you want the quotation to appear in the text!',null,'article');?>
						<input type="text" value="{/quotation/}">
					</div>
					<?php if ($user_profile->hasCredential('article_editor') ):?>
					<label for="article_bg_slug"><?php echo __('SEO',null,'article');?></label>
					<div class="form_box form_item">
					<div class="form_box<?php if( $form[$lng]['slug']->hasError() || $sf_user->getFlash('slug_culture_error')):?> error<?php endif;?> ">
						<?php echo $form[$lng]['slug']->renderLabel()?>
						<?php echo $form[$lng]['slug'] ?>
						<?php echo $form[$lng]['slug']->renderError()?>
					</div>
					<div class="form_box<?php if( $form[$lng]['keywords']->hasError()):?> error<?php endif;?> ">
						<?php echo $form[$lng]['keywords']->renderLabel()?>
						<?php echo $form[$lng]['keywords'] ?>
						<?php echo $form[$lng]['keywords']->renderError()?>
					</div>
					<div class="form_box<?php if( $form[$lng]['description']->hasError()):?> error<?php endif;?>">
						<?php echo $form[$lng]['description']->renderLabel()?>
						<?php echo $form[$lng]['description'] ?>
						<?php echo $form[$lng]['description']->renderError()?>
					</div>
					</div>
					<?php endif;?>
				</div>
				<div id="tab_1" class="article_tab_in" style="display:none;">
					<div class="form_box form_label_inline<?php if( $form['en']['title']->hasError()):?> error<?php endif;?>">
						<?php echo $form['en']['title']->renderLabel()?>
						<?php echo ' ('. __('English').')'?><span class="pink">*</span><br />
						<?php echo $form['en']['title'] ?>
						<?php echo $form['en']['title']->renderError()?>
					</div>
						<div class="form_box form_label_inline <?php if( $form['en']['content']->hasError()):?> error<?php endif;?>">
						<?php echo $form['en']['content']->renderLabel()?>
						<?php echo ' ('. __('English').')'?><span class="pink">*</span><br />
						<?php echo $form['en']['content'] ?>
						<?php echo $form['en']['content']->renderError()?>
					</div>
					<div class="form_box form_label_inline<?php if( $form['en']['quotation']->hasError()):?> error<?php endif;?>">
						<?php echo $form['en']['quotation']->renderLabel()?>
						<?php echo ' ('. __('English').')'?><br />
						<?php echo $form['en']['quotation'] ?>
						<?php echo $form['en']['quotation']->renderError()?>
						<?php echo __('Copy this code and position it where you want the quotation to appear in the text!');?>
						<input type="text" value="{/quotation/}">
					</div>
					<?php if ($user_profile->hasCredential('article_editor') ):?>
					<div class="form_box form_label_inline">
						<label for="article_bg_slug"><?php echo __('SEO',null,'article');?></label>
						<?php echo ' ('. __('English').')'?><br />
						<div class="form_box form_item">
							<div class="form_box<?php if( $form['en']['slug']->hasError() || $sf_user->getFlash('slug_en_error')):?> error<?php endif;?> ">
								<?php echo $form['en']['slug']->renderLabel()?>
								<?php echo $form['en']['slug'] ?>
								<?php echo $form['en']['slug']->renderError()?>
							</div>
							<div class="form_box form_label_inline<?php if( $form['en']['keywords']->hasError()):?> error<?php endif;?>">
								<?php echo $form['en']['keywords']->renderLabel()?>
								<?php echo ' ('. __('English').')'?><br />
								<?php echo $form['en']['keywords'] ?>
								<?php echo $form['en']['keywords']->renderError()?>
							</div>
								<div class="form_box form_label_inline <?php if( $form['en']['description']->hasError()):?> error<?php endif;?>">
								<?php echo $form['en']['description']->renderLabel()?>
								<?php echo ' ('. __('English').')'?><br />
								<?php echo $form['en']['description'] ?>
								<?php echo $form['en']['description']->renderError()?>
							</div>
						</div>
					</div>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="form_wrap">
			<?php foreach($form['newImages'] as $k=>$img):?>
				<div class="form_box form_list_item form_label_inline <?php if($k%2==0) echo "cl";?>">
			    	<div class="frm1-box"> 
			    		<?php //echo $form->getEmbeddedForm("newImages")->getEmbeddedForm($k)->renderGlobalErrors();?>
						<?php echo $img['filename']->renderLabel()?>
						<span><?php echo $img['filename']->renderHelp()?></span>
						<div class="form-input<?php echo $img['filename']->hasError() ? ' error': ''?>">
							<?php echo $img['filename']->render(array('class' => 'image_title'))?>
						</div>
						<?php echo $img['descrption']->renderLabel()?>
						<span><?php echo $img['descrption']->renderHelp()?></span>
						<div class="form-input<?php if( $img['descrption']->hasError()):?> error<?php endif;?>">
							<?php echo $img['descrption']->render()?>
						</div>
						<?php echo $img['source']->renderLabel()?><span class="pink">*</span>
						<span><?php echo $img['source']->renderHelp()?></span>
						<div class="form-input<?php if( $img['source']->hasError()):?> error<?php endif;?>">
							<?php echo $img['source']->render()?>
						</div>
					</div><!-- frm1-box -->
				</div>
			<?php endforeach;?>
			<div class="clear"></div>
		</div>
		<?php if ($user_profile->hasCredential('article_editor') && !$form->getObject()->isNew()):?>

		<div class="form_box"<?php if( $form['location_id']->hasError()):?> error<?php endif;?> style="margin-bottom:25px;">
			<?php echo $form['location_id']->renderLabel()?>
			<?php echo $form['location_id'] ?>
			<?php echo $form['location_id']->renderError()?>
		</div>

		<div class="form_list_wrap">
			<h3><?php echo __('Related Places',null,'article');?></h3>
			<div>
				<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
				<div class="viewport">
					<div class="overview">
						<ul id="list_of_places">
							<?php include_component('article', 'places', array('article' => $form->getObject(), 'form' => $form)); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="form_list_wrap">
			<h3><?php echo __('Related Lists',null,'article');?></h3>
			<div>
				<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
				<div class="viewport">
					<div class="overview">
						<ul id="list_of_lists">
							<?php include_component('article', 'lists', array('article' => $form->getObject(), 'form' => $form)); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="form_list_wrap">
			<h3><?php echo __('Related Events',null,'article');?></h3>
			<div>
				<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
				<div class="viewport">
					<div class="overview">
						<ul id='list_of_events'>
							<?php include_component('article', 'events', array('article' => $form->getObject(), 'form' => $form)); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
			<div class="form_box" style="margin-bottom:25px;">
				<div class="form_select_inline">
					<input type="radio" name="group1" value="1" checked />
					<?php echo __('Places');?>
				</div>
				<div class="form_select_inline">
					<input type="radio" name="group1" value="2" />
					<?php echo __('Lists');?>
				</div>
				<div class="form_select_inline">
					<input type="radio" name="group1" value="3" />
					<?php echo __('Events',null,'events');?>
				</div>
				<div class="clear"></div>
				<div class="form_box">
					<input type="text" id="locate_item" style="width: 691px;"/>
				</div>
				<div id="item_list"></div>
			</div>




	<?php /*?>
		<div class="form_box" style="margin-bottom:25px;">
		<div class="form_list_wrap">
			<h3><?php echo __('Category',null,'article');?></h3>
			<div>
				<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
				<div class="viewport">
					<div class="overview">
						<ul id='list_of_events'>
							<?php include_component('article', 'categories', array('article' => $form->getObject(), 'form' => $form)); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="form_box">
			<input type="text" id="locate_category" style="width: 691px;"/>
		</div>

		<div id="category_list"></div>
		</div>
<?php */?>
		<div class="form_list_wrap auto "<?php if( $form['status']->hasError()):?> error<?php endif;?> style="margin-bottom:25px;">
				<?php echo $form['status']->renderLabel()?>
				<?php echo $form['status'] ?>
				<?php echo $form['status']->renderError()?>
		</div>
        <?php if (!$form->getObject()->isNew() && $user_profile->hasCredential('article_editor')): ?>
            <div class="form_list_wrap auto">
                    <?php echo $form['user_id']->renderLabel()?>
                    <?php echo $form['user_id'] ?>
                    <?php echo $form['user_id']->renderError()?>
            </div>
        <?php endif ?>


        <div class="clear"></div>
        <div class="form_wrap" id="publish-on" style="display: none">
            <?php echo $form['publish_on']->renderLabel()?>
            <?php echo $form['publish_on'] ?>
            <?php echo $form['publish_on']->renderError()?>
        </div>

	<?php endif;?>


	<?php if (!$form->getObject()->isNew()):?>
		<div class="form_list_wrap <?php echo ($form['category_id']->hasError() ? 'error' : '');?>">
			<h3><?php echo $form['category_id']->renderLabel()?></h3>
			<div id="list_of_categories">
				<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
				<div class="viewport">
					<ul class="overview"></ul>
				</div>
			</div>
			<?php echo $form['category_id']->renderError()?>
		</div>
		<?php echo $form['category_id'] ?>
	 	<div class="clear"></div>

	<?php endif;?>

		<div class="form_box">
			<input type="submit" value="<?php echo $form->getObject()->isNew() ? __( 'Next',null,'list') :__( 'Publish',null,'messages') ?>" class="button_green" />
			<?php if(!$form->getObject()->isNew() && $form->getObject()->getStatus() == 'approved' ):?>
				<a href="<?php echo url_for('@article?slug='.$form->getObject()->getSlug() );?>"><?php echo __('Go to Article',null,'article')?></a>
			<?php endif;?>
		</div>

		<?php echo  $form->renderHiddenFields();?>
	</form>

    <script type="text/javascript">
        $(document).ready(function(){
            $("form#articleForm").submit(function(){
              $('input').attr('readonly', true);
              $('input[type=submit]').attr("disabled", "disabled");
              $('a').unbind("click").click(function(e) {
                  e.preventDefault();
              });
            });
            $("#article_status").on('change', function () {
                if ($(this).val() == 'publish_on') {
                    $("#publish-on").slideDown();
                } else {
                    $("#publish-on").slideUp();
                }
            }).trigger('change');
        });
    </script>
    
    
	<?php if (! $form->getObject()->isNew()):?>
	<div class="event_settings_content"></div>
	<script type="text/javascript">
	$(document).ready(function() {

		$.ajax({
				url: '<?php echo url_for('article/images?article='.$form->getObject()->getId());?>',
				beforeSend: function( ) {
					$('.event_settings_content').html('<div class="review_list_wrap">loading...</div>');
				  },
				success: function( data ) {
					$('.event_settings_content').html(data);
				}
			});

		})
	</script>
	<?php endif;?>
</div>

<script type="text/javascript">

$(document).ready(function() {
	$('.standard_tabs_top a').click(function() {
		$('.standard_tabs_in>div').css('display', 'none');
		$($(this).attr('href')).css('display', 'block');
		$('.standard_tabs_top a').removeClass('current');
		$(this).addClass('current');
		return false;
	});
})
</script>
<script type="text/javascript">
<?php if (!$form->getObject()->isNew()):

	  	$art_cats = Doctrine::getTable('ArticleCategory')
	  	->createQuery('ac')
	  	->where('ac.article_id = ?',$form->getObject()->getId())
	  	->execute();
	?>
$(document).ready(function(){
<?php foreach ($art_cats as $art_cat):?>
	$('#article_category_id option[value="<?php echo $art_cat->getCategoryId()?>"]').attr('selected','selected');
<?php endforeach;?>

	$('#article_category_id option').each(function() {
		if ($(this).attr('selected') == 'selected')
			$('#list_of_categories ul.overview').append('<li rel="' + $(this).attr('value') + '">' + $(this).text() + '<img src="/images/gui/checked.png" /></li>');
		else
			$('#list_of_categories ul.overview').append('<li class="pink" rel="' + $(this).attr('value') + '">' + $(this).text() + '</li>');
	});

	$('#list_of_categories ul li').live('click', function() {
		if ($(this).hasClass('pink')) {
			$(this).removeClass('pink');
			$(this).append('<img src="/images/gui/checked.png" />');
			$('#article_category_id option[value="'+ $(this).attr('rel') + '"]').attr('selected', 'selected');
		}
		else {
			$(this).addClass('pink');
			$(this).children('img').remove();
			$('#article_category_id option[value="'+ $(this).attr('rel') + '"]').removeAttr('selected');
		}
	});

	//$('.article_form_wrap form').submit(function() {

	//});

$('.standard_tabs_top a').click(function() {
		$('.standard_tabs_in>div').css('display', 'none');
		$($(this).attr('href')).css('display', 'block');
		$('.standard_tabs_top a').removeClass('current');
		$(this).addClass('current');
		return false;
	});

	$('.form_list_wrap > div').tinyscrollbar();

	$('.form_list_wrap').each(function() {
		if ($(this).find('.disable').length > 0) {
			$(this).css({'padding-right': '10px', 'width':'199px'});
			$(this).find('.viewport').css('width', '199px');
		}
	});

	$('#form_close').click(function() {
		$("#PlacesList").css('display', 'none');
	});

	$('.ez-radio input').click(function() {
		$('#item_list').html('');
	});

	$('#locate_item').keyup(function() {
		var values = $(this).val();
		var selected = $('input[type="radio"]:checked').val();
		var container = $('#item_list');
		var cityId = $('#article_location_id').val();
		var articleId = <?php echo $form->getObject()->getId() ?>;

		if (values.length > 2) {
			$("#item_list").css("display", "block");
			container.html('');
			var url = '';
			if (selected == 1) {
				url = '<?php echo url_for("article/getPage") ?>';
			}
			else if (selected == 2) {
				url = '<?php echo url_for("article/getList") ?>';
			}
			else if (selected == 3) {
				url = '<?php echo url_for("article/getEvent") ?>';
			}

			$.ajax({
				url: url,
					data: {'values': values, 'articleId': articleId, 'cityId': cityId},
				success: function(data, url) {
					container.html(data);
			    },
			    error: function(e, xhr)
			    {
			        console.log(xhr);
			    }
			});
		}
		else{
			  $("#item_list").css("display", "none");
			  $("#item_list").html('')
			}
	});

<?php /*?>
	$('#locate_category').keyup(function() {
		var values = $(this).val();
		var container = $('#category_list');
		var articleId = <?php echo $form->getObject()->getId() ?>;

		if (values.length > 2) {
			$("#category_list").css("display", "block");
			container.html('');
			url = '<?php echo url_for("article/getCategory") ?>';

			$.ajax({
				url: url,
					data: {'values': values, 'articleId': articleId},
				success: function(data, url) {
					container.html(data);
			    },
			    error: function(e, xhr)
			    {
			        console.log(xhr);
			    }
			});
		}
		else{
			  $("#category_list").css("display", "none");
			  $("#category_list").html('')
			}
	});
<?php */?>
	$("#list_of_places a, #list_of_lists a, #list_of_events a").live('click', function() {
		var Id = $(this).attr('id');
		var thisEl = $(this);
		var row = $(this).parent();

		var container = row.parent();
		var url = '';
		if (container.attr('id') == 'list_of_places')
			url = '<?php echo url_for("article/delPageFromArticle") ?>';
		else if (container.attr('id') == 'list_of_lists')
			url = '<?php echo url_for("article/delListFromArticle") ?>';
		else if (container.attr('id') == 'list_of_events')
			url = '<?php echo url_for("article/delEventFromArticle") ?>';

		$.ajax({
			url: url,
			data: {'Id': Id},
			success: function(data, url) {
				$(row).remove();
				$('.form_list_wrap > div').tinyscrollbar({size: 215});
			},
			error: function(e, xhr)
			{
				console.log(xhr);
			}
		});
		return false;
	});
});
<?php endif;?>
</script>

<?php include_partial('global/keepAlive'); ?>