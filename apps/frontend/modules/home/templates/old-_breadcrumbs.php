<div class="path">
  <a title="<?php echo __('Homepage'); ?>" href="<?php echo url_for('@homepage'); ?>"><?php echo __('homepage'); ?></a>
  <?php $i=0;foreach ($list as $title => $url): $i++ ?>
    <?php if ($url): ?>
        <a class="" href="<?php echo $url; ?>" title="<?php echo __($title); ?>"><?php echo __($title); ?></a>
    <?php  else: ?>
        <b><?php echo __($title); ?></b>
    <?php endif; ?>
    
    <?php if($i != sizeof($list)) echo '/' ?>
  <?php endforeach; ?>
</div>
