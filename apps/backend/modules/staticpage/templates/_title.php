<?php
    $level = $static_page->getLevel();
    if ($level > 0) {
      echo str_repeat('&nbsp;', $level * 3) . '-';
    }    
?>

<?php echo link_to($static_page->getTitle(),'/'. $sf_user->getCulture().'/page/'.$static_page->getSlug(), 'target=_blank') ?>