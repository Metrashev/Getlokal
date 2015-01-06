<?php
function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
?>
<?php
  $width = $sf_request->getParameter('width');
  $height = $sf_request->getParameter('height');
  $isS = ($width / $height) < 1; // is Streched
  $placeLink = url_for(sprintf('@company?city=%s&slug=%s', $company->getCity()->getSlug(),
    $company->getSlug()));
?>
<div class="image">
  <?php
    if ($company->getImage()) {
      echo link_to(image_tag($company->getImage()->getThumb(2)), $placeLink, array(
        'target' => '_blank'
      ));
    }
  ?>
</div>
<?php if (!$isS): ?>
  <?php include_partial('more', array('link' => $placeLink)) ?>
<?php endif ?>
<div class="info">
  <h1>
    <a title="<?php echo $company->getCompanyTitle(); ?>" href="<?php echo $placeLink ?>" target="_blank">
      <?php echo substr_unicode($company->getCompanyTitle(), 0, 42); ?><?php echo (mb_strlen($company->getCompanyTitle(), 'UTF-8') > 42 ? '...' : '') ;?>
    </a>
  </h1>
  <div class="rating">
    <?php include_partial('rating', array('rating' => $company->getAverageRating())) ?>
  </div>
  <div class="recommends">
    <?php echo format_number_choice(
      '[0]No reviews|[1]1 review|(1,+Inf]%count% reviews',
      array('%count%' => $company->getNumberOfReviews()),
      $company->getNumberOfReviews(),
      'user'
    ) ?>
  </div>
  <div class="category">
    <?php
      $title = sprintf('<b>%s</b> / %s', $company->getClassification(), $company->getCity()->getLocation());
      echo link_to($title, $company->getClassificationUri(ESC_RAW), array(
        'title' => strip_tags($title),
        'target' => '_blank'
      ));
    ?>
  </div>
  <?php if ($company->getPhoneFormated()): ?>
    <div class="phone">
      <i class="fa fa-phone"></i>
      <?php echo $company->getPhoneFormated() ?>
    </div>
  <?php endif ?>
  <div class="address">
    <i></i>
    <?php echo $company->getDisplayAddress() ?>
  </div>
</div>

<?php if ($isS): ?>
 <?php include_partial('more', array('link' => $placeLink)) ?>
<?php endif ?>
