<?php $pages = $list->getAllListPage()?>

<?php 

//IMAGE CONSTRUCTORS $thumb_options,$image_path & $thumb
$thumb_options = array('size'=>'125x125', 'alt' => $list->getTitle());
$thumb = null;
if ($list->getImageId()){ 
	$image_path =  image_path($list->getThumb('preview'), true);
	$thumb = $list->getThumb(0);
}elseif (count($pages)){
	foreach ($pages as $company){
		if ($company->getCompanyPage()->getCompany()->getImageId()){
			$image_path =  image_path($company->getCompanyPage()->getCompany()->getThumb(0), true);
			$thumb = $company->getCompanyPage()->getCompany()->getThumb(0);
			break;
		}
	}
}
 
$show=false;
if($user && $user->getId() && ( $user->getId()==$list->getUserId() ||  $list->getIsOpen() ) ):
$show=true;
endif;
?>

<?php slot('facebook') ?>
		<meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_'.$sf_user->getCountry()->getSlug().'_id');?>"/>
		<meta property="og:title" content="<?php echo $list->getTitle(); ?>" />
		<?php if (isset($image_path)):?>
		<meta property="og:image" content="<?php echo $image_path ?>" />
		<?php endif;?>
		<meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
  		<meta property="og:country-name" content="<?php echo $sf_user->getCountry() ?>" />
  		<meta property="og:url" content="<?php echo url_for('list/show?id='.$list->getId(), true) ?>" />
<?php end_slot() ?>
	
<?php include_partial('listHeader') ?>
<div class="wrapper-list-details-slider smaller-z-index">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 path-holder-margin">
            	<?php include_partial('global/breadCrumb') ?>
            </div>
            <div class="col-sm-12 list-details-articles">

                <div class="image-list">
                    <a href="#">
                        <?php echo image_tag($thumb,$thumb_options); ?>
                        <!-- <img src="http://lorempixel.com/125/125/" alt=""> -->
                    </a>
                </div>
                <div class="list-details">
                    <div class="custom-row">
                        <div class="txt-list">
                            <h1><?php echo $list->getTitle(); ?>
                            	<?php 
                            	$c_ = $list->getIsOpen() ? "unlock" : "lock";
                            	$t_ = $list->getIsOpen() ? "This list is open." : "This list is locked.";
                            	?>
                            	<span class="page-icon-list <?= $c_?>"> <!-- !!!!!! change class lock / unlock to change icon -->
                                    <span class="wrapper-tooltip-list-details"><span class="tooltip-arrow-lists"></span><span class="tooltip-body-lists"><?= $t_?></span></span>
                                </span>
                            </h1>   
                            <a href="#"><?php echo format_number_choice('[0]0 places|[1]1 place|(1,+Inf]%count% places', array('%count%' => count($pages)), count($pages),'list'); ?></a>
                        </div>
                        <div class="list-details-article-uploader">
                            <div class="profile-information">
                                <div class="profile-image">
                                    <a href="#">
                                    <?php echo image_tag($list->getUserProfile()->getThumb(), array('size'=>'55x55', 'alt' => $list->getUserProfile())) ?>
        <!--                                 <img src="http://lorempixel.com/55/55/" alt=""> -->
                                    </a>
                                </div><!-- profile-image -->
                                <div class="profile-content">
                                    <?php $file = ($sf_user->getCulture() == 'sr' && $list->getUserProfile()->getGender() == 'f') ? 'dashboardf' : 'list'; ?>
                                    <p><?php echo __('This list is created by', null, $file)." "; ?></p>
                                    <h3><?php echo $list->getUserProfile()->getLink(ESC_RAW) ?></h3>
                                    <a class="more-events-list-by" href="<?php echo  url_for('@user_page?username='. $list->getUserProfile()->getSfGuardUser()->getUsername().'&listTab=true#lists_tab')?> "><?php echo __('More lists from', null, 'list')." ".$list->getUserProfile()?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-details-paragraph-desc">
                        <p><?php echo html_entity_decode ($list->getDescription()); ?></p>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- END list-container -->

            <!-- ================================ -->

            <!-- ************START CONTENT-DETAIL-PAGE**************** -->
            <div class="container">
                <div class="row">
                    <div class="list-details-page top-places col-sm-12 boxesToBePulledDown">
                        <div class="all-lists">
                            <div class="social-bar floated">
                                <div class="social-info-text list-details-social-info"><?php echo __('SHARE', null, 'company'); ?></div>
                                <?php if($is_place_admin_logged):?>
                                <?php $sf_user->setAttribute('redirect_after_login', url_for('list/create'));?>
                                    <?php echo link_to(sprintf(__('Login as %s and Create List', null, 'user'), $sf_user->getGuardUser()->getUserProfile()) , 'companySettings/logout', array('class'=>'default-btn pull-right sign-in-and-create-list')) ?>
                                 <?php else :?>
                                    <a class="default-btn success add-new-list-btn" href="<?php echo url_for('list/create' )?>"><span class="plus-icon-add-new-list"></span></span><?php echo __('Create a List Now', null, 'list') ?></a>
                                <?php endif;?>

                                <?php if(!$is_place_admin_logged):?>
                                  <?php if ($user && $user->getId()==$list->getUserId()) :?>
                                      <a class="default-btn success add-new-list-btn" href="<?php echo url_for('list/edit?id='.$list->getId() )?>"><?php echo __('Edit List', null, 'list')?></a>
                                  <?php endif;?>
                                <?php endif;?>

                                <div class="socials-container list-details-social-container show-list-margin">
                                    <?php include_partial('global/social', array('hasSocialScripts' => true, 'hasSocialHTML' => true)); ?>
                                </div>
                            </div>
                            
                        </div>
                        <div class="add-place-to-list col-sm-8">
                            <div class="clear"></div>
		            <div class="places_in_list">
                                <div class="content_in">
                                    <?php if($show):?>
                                        <div class="default-container default-form-wrapper show-list-fix col-sm-12">
                                            <div class="list_searchform_wrapper">
                        						
                                                <div id="dropdown_search">

                        							<div class="default-form clearfix">
                                                        <!-- <div class="form_box">
                        									<?php //echo $form['place_id']->renderLabel()?>
                        									<input id="search_place" type="text" placeholder="<?php echo __('Click to add places to this list!', null, 'list') ?>" autocomplete="off"/>
                        								</div> -->
                                                        <div class="row">
                                                        
                                                            <div class="col-sm-6">
                                                                <div class="default-input-wrapper active form_box">
                                                                    <div class="required-txt"></div>
                                                                    <div class="error-txt"></div>
                                                                    <label for="name" class="default-label"><?php echo __('Click to add places to this list!', null, 'list') ?></label>
                                                                    <input type="text" id="search_place" placeholder="<?php echo __('Click to add places to this list!', null, 'list') ?>" class="default-input" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">

                                                                <div class="default-input-wrapper active <?php if( $form['location_id']->hasError()):?> error<?php endif;?>">
                                                                    <div class="required-txt"></div>
                                                                    <div class="error-txt"><?php echo $form['location_id']->renderError()?></div>
                                                                    <?php echo $form['location_id']->renderLabel(null, array('class' => 'default-label')) ?>
                                                                    <!-- <input type="text" placeholder="<?php echo $form['location_id'] ?>" class="default-input" autocomplete="off"> -->
                                                                    <?php echo $form['location_id']->render(array('class' => 'default-input visible-important')); ?>
                                                                </div>

                                                                <!-- <div class="form_city<?php if( $form['location_id']->hasError()):?> error<?php endif;?>">
                                                                    <?php echo $form['location_id']->renderLabel()?>
                                                                    <?php echo $form['location_id'] ?>
                                                                    <?php echo $form['location_id']->renderError()?>
                                                                </div> -->

                                                            <!--<ul class="tag-wrapper">
                                                                    <li class="tag"><a href="javascript:void(0);" id="search_city_name"></a><i class="close"></i> </li>
                                                                </ul> -->
                                                            </div>

                                                        </div>
                        								
                                                        <div class="clear"></div>
                        							</div>
                        							<div class="form_box show-list">
                        								<div id="PlacesList" class="list_of_places places_dropdown">
                        									<a href="javascript:void(0)" id="form_close"></a>
                        									<div><div class="scrollbar">
                        									<div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                        									<div class="viewport"><div class="overview"></div></div></div>
                        								</div>
                        							</div>
                        						</div>

                                            </div>
                                        </div>
					<?php endif;?>
                            <div id="list_places_ul">
                            <?php 
	                            $options = array( //'places' => $pages,
	                            		'pager' => $pager,
	                            		'culture'=>$sf_user->getCulture(),
	                            		'user'=>$user,
	                            		'listUserId'=>$list->getUserId(),
	                            		'listId'=>$list->getId(),
	                            		'is_place_admin_logged'=>$is_place_admin_logged
	                            );
                            	include_partial('places_pager',$options);
                            ?>
                            </div>
                            <div class="listing_place">
					<?php if(!$sf_user->isAuthenticated() && $list->getIsOpen()): ?>
							<a href="javascript:void(0);" id="addplace" class="default-btn success list-details-add-place-btn"><i class="fa fa-plus"></i><?php echo __('Add Place') ?></a>
                            <div id="login_form_add_to_list" class="login_form_wrap" style="display:none">
                                <a href="javascript:void(0)" id="header_close"></a>
                                <?php include_component('user', 'signinRegister',array('trigger_id' => 'addplace', 'button_close' => true));?>
                            </div>
					<?php endif; ?>
					</div>

					<?php if($sf_user->getCulture() == 'sr' && $list->getUserProfile()->getGender() == 'f') :?>
						<?php $file = 'dashboardf'; ?>
					<?php else :?>
						<?php $file = 'list'; ?>
					<?php endif; ?>


                                    </div>
				</div>
                        </div> <!-- add-place-to-list col-sm-8 -->
                        <div class="map-list col-sm-4">
                        	<?php include_partial('global/map')?>
<!--                         	<div>MAP</div> -->
                        	<?php /*
                           <div class="default-container">
                                <h3 class="heading"><?php echo __('Sponsored'); ?></h3> <!-- END heading -->
                                <div class="content">
                                    <a href="#"><img src="css/images/sponsored.png" alt="" width="0" height="0" style="display: none !important; visibility: hidden !important; opacity: 0 !important; background-position: 1px 1px;"></a>
                                </div> <!-- END content -->
                            </div>
                            */?>
                        </div>
                    </div> <!-- end list-detail-page -->
				</div>
			</div>
                    <!-- START COMMENT -->

    <div class="container">
        <div class="row">
            <div class="col-sm-8 list-details-comments">
                <div class="wrapp-comment-header">
                    <h3 class="comment-header"><?php echo __('Comments'); ?></h3>
                </div>
                <div class="lists-details-facebook-plugin">
                    <?php include_partial('global/facebook_comments')?>
                    <div class="pp-tabs">
                        <div class="pp-tabs-body">
                            <div class="pp-tab" style="display: block;">
                                <?php include_component('comment', 'comments', array('activity' => $list->getActivityList(), 'user' => $user, 'url'=>url_for('list/comments?list_id='. $list->getId()), 'pager_class'=>'list_comments')) ?>
                            </div><!-- pp-tab -->                       
                        </div><!-- pp-tabs-body -->
                    </div> <!-- pp-tabs-end -->
                </div>  <!-- end facebook plugin -->      
            </div><!-- END COMMENT -->
        </div>
    </div>
</div> <!-- end wrapper-list-details-slider -->

<script type="text/javascript">

//==========================================================
// http://getlokal.my/frontend_dev.php/bg/d/list/show/id/847
// too long comment to be checked!!!!
//==========================================================
	
$(document).ready(function(){
  
	if ($('.sidebar .comments .review').length == 0)
	{
		//$('.sidebar .comments').prepend('<div class="review review_list_company"><a href="javascript:void(0);" title="getLokal">getLokal</a><a class="review_list_img" href="javascript:void(0);" title="getLokal"><img width="100" height="100" title="getLokal" alt="getLokal" src="/images/gui/getlokal_profile.jpg"></a><div class="review_content"><p>'+"<?php echo 'hello there'?>"+'</p></div></div>');
	}
        <?php if(!$sf_user->isAuthenticated()): ?>
            $('#addplace').click(function() {
                $('#login_form_add_to_list').toggle('normal');
            });
        <?php endif; ?>
         <?php if($show):?>
	$('.close_form_report').on('click', function() {
		$('.sidebar').find('.ajax').css('display', 'none');
		$('.sidebar').find('.add_review').css('display', 'block');
	});

	var city_clicked = false;
	$('a#search_city_name').text($('#autocomplete_list_location_id').val());
	$('a#search_city_name').click(function() {
           
		if (!city_clicked)
		{        $('#search_place').addClass('shorten');
			$(this).toggle('fast');
			$(this).parent().css({padding: '15px 10px'});
			$(this).parent().children('input').toggle('fast', 'swing', function() {
				$(this).parent().children('input').focus();
				city_clicked = true;
			});
		}
	});
	$('#autocomplete_list_location_id').blur(function() {
             
		if (city_clicked)
		{       $('#search_place').removeClass('shorten');     
			val = $(this).val();
			if ($.trim(val) != '') {
				$(this).parent().children('a').text(val.split(',')[0]);
			}
			else {
				$(this).val($(this).parent().children('a').text());
			}
			city_clicked = false;
		}
		$(this).toggle('fast');
		$(this).parent().children('a').toggle('fast', 'swing', function() {
			$(this).parent().css({padding: '22px 10px 20px'});
		});
	});

	$('.ac_results').on('mouseup', function(e) {
		$('#search_city_name').text($('.ac_over').text().split(',')[0]);
	})

	$('#PlacesList > div').tinyscrollbar({ size: 120 });
	  $('.form_search').css('width', '594px');

  	$('#form_close').click(function() {
  		$("#PlacesList").css('display', 'none');
	});

  $('body').bind('click', function(e) {
	    if($(e.target).closest('#dropdown_search').length == 0) {
	    	$("#PlacesList").css('display', 'none');
	    }
	});
  $('#search_place').keyup (function(){
	  //console.log($('#list_location_id').val());
	  var values = $(this).val();
	  var cityId = $('#list_location_id').val();
	  var listId = <?php echo $form->getObject()->getId() ?>;
	  $('#PlacesList').css('width', ($('.form_search').width() - 26));
	  $('.viewport').css({'width': ($('.form_search').width() - 61), height: '138px'});

	  if(values.length > 2){
		  $("#PlacesList").css('display', 'block');
    	$.ajax({
			url: '<?php echo url_for("list/getPage") ?>',
				data: {'place': values, 'listId': listId, 'cityId': cityId},
			success: function(data, url) {
				$("#PlacesList").attr('data', 'show');
				$("#PlacesList .overview").html(data);
				$("#PlacesList .overview div div a").each(function() {
					$(this).html($(this).html().replace(values, '<span>' + values + "</span>"));
				});
				$("#PlacesList > div").tinyscrollbar_update();
				if ($('#PlacesList .overview').outerHeight() < $('#PlacesList .viewport').outerHeight()) {
					$('#PlacesList .viewport').css('height', $('#PlacesList .overview').outerHeight());
					$('#PlacesList').css('height', 'auto');
				}

			},
		    error: function(e, xhr)
		    {
		        console.log(xhr);
		    }
		});
	  }
	  else{
		  $("#PlacesList").css("display", "none");
		  }
  });
  <?php endif;?>
        
});
</script>