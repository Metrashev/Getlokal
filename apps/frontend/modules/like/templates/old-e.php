<div>
  <a name="like-<?php echo $object->getId() ?>"></a>
  <?php $class = 'vote'; if(in_array($object->getId(), $sf_data->getRaw('sf_user')->getAttribute('likes', array(), ESC_RAW)) || $object->getUserLike()) $class = 'vote voted'; ?>
  <a href="<?php echo url_for('like/save?id='. $object->getId().'like-'.$object->getId()) ?>" class="<?php echo $class ?>"><?php echo __('Vote')?> <span><?php echo $object->getTotalLikes() ?></span></a>
</div>