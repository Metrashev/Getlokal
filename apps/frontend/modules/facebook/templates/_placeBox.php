<?php if(!$sf_request->isXmlHttpRequest()): ?>
<form action="<?php echo url_for('facebook/reviewSave') ?>" method="post" class="review_form">
<?php endif ?>
<input type="hidden" name="id" value="<?php echo $company->getId() ?>" />
<input type="hidden" name="ids[]" value="<?php echo $company->getId() ?>" class="ids" />

<?php // echo $form['_csrf_token'] ?>
<div class="place_box" id="form_<?php echo $company->getId() ?>">
  <a href="#" class="reload" rel="<?php echo $company->getId() ?>"><?php echo image_tag('facebook/v2/reload.png') ?></a>
  
  
  <?php if(count($company->getCompanyImage())): ?>
    <div class="picture">
      <?php echo link_to(image_tag($company->getThumb(2), array('absolute' => true)), $company->getUri(ESC_RAW), 'target=_blank')  ?>
    </div>
  <?php else: ?>
    <a href="<?php echo url_for($company->getUri(ESC_RAW))?>" target="_blank"><img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&zoom=15&size=260x135&maptype=roadmap&markers=icon:<?php echo image_path('gui/icons/small_marker_'. $company->getSectorId(), true) ?>%7Cshadow:false%7C<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&sensor=false" class="map_image" /></a>
  <?php endif ?>
  
  
  <p class="place_title"><?php echo link_to($company.image_tag('facebook/v2/new_window.gif', 'align=absmiddle'), $company->getUri(ESC_RAW), 'target=_blank') ?></p>
  <p><?php echo $company->getClassification() ?></p>
  
  <div class="separator"></div>
  
  <?php if($sf_user->getCountry()->getSlug() == 'mk'): ?>
	  <p class="address"><b>Адреса</b>: <?php echo $company->getDisplayAddress() ?></p>
  <?php else: ?>
  	  <p class="address"><b><?php echo __('Address') ?></b>: <?php echo $company->getDisplayAddress() ?></p>
  <?php endif; ?>
  
  
    <p class="section"><?php echo __('Reviews form other users') ?></p>
    
    <div class="other_reviews">
      <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
      <div class="viewport">
        <div class="overview">
        
        <?php foreach($company->getReviews() as $i=>$review): ?>
          <p><strong><?php echo $review->getDateTimeObject('created_at')->format('d.m.Y') ?></strong><br>
          <strong><?php echo $review->getUserProfile() ?></strong>: <?php echo $review->getText() ?></p>
        <?php endforeach ?>
        <?php if(!isset($i)): ?>
          <?php echo __('There are no reviews for %s yet. Be the first to write one.', array('%s' => $company->__toString())) ?>
        <?php endif ?>
        </div>
      </div>
    </div>
  
  <p class="section"><?php echo __('Your review') ?></p>
  
  <div class="body">
    <?php if($form->isBound() && $form->isValid()):?>
      <div class="success"><?php echo __('We saved your review. Thanks!') ?></div>
    <?php else: ?>
    <?php if($form['text']->hasError()): ?>
      <?php echo $form['text']->renderError() ?>
    <?php else: ?>
      <label><?php echo __('Text') ?></label>
    <?php endif ?>
    
    <?php echo $form['text']->render() ?>
    <?php endif ?>
  </div>
  
  <div class="submitbox">
    <?php if($form->isBound() && $form->isValid()):?>
      <a href="#" class="submit button" style="width: 240px;" onclick="$(this).parent().parent().find('.reload').click(); return false"><?php echo __('Load another place') ?></a>
    <?php else: ?>
      <div class="rate"><?php echo __('Rate') ?>:</div>
      <a href="#" class="star" rel="1"></a>
      <a href="#" class="star" rel="2"></a>
      <a href="#" class="star" rel="3"></a>
      <a href="#" class="star" rel="4"></a>
      <a href="#" class="star" rel="5"></a>
      
      <input type="hidden" name="<?php echo $form['rating']->renderName() ?>" class="rating" value="<?php echo $form['rating']->getValue() ?>" />
      <input type="submit" class="submit" value="<?php echo __('Save') ?>">
      
      <div class="clear"></div>
      
      <?php echo $form['rating']->renderError() ?>
    <?php endif ?>
    <div class="clear"></div>
  </div>
</div>

<?php if($sf_request->isXmlHttpRequest()): ?>
<script>
$('.reviews div b, strong.reviews span').html('<?php echo $count ?>');
$('.reviews > b').html('<?php echo floor($count / 3) ?>');
$('strong.chance span').html('<?php echo format_number_choice('[0]%s chance|[1]%s chance|(1,+Inf]%s chances', array('%s' => floor($count / 3)), floor($count / 3)) ?>');
<?php if($form->isValid() && $form->isBound() && $count % 3 == 0): ?>
  $('.lightbox').show();
  $('.overlay').show();
<?php endif ?>
</script>
<?php else: ?>
</form>
<?php endif ?>
<script type="text/javascript">
$(function() {
  init('form_<?php echo $company->getId() ?>');
})
</script>