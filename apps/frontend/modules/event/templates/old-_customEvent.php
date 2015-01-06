<div class="list_event">
    <a class="img_wrap" href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo $event->getDisplayTitle(); ?>">
        <?php if ($event->getImageId() && $event->getImage()->getFileName()) : ?>
	        <?php echo image_tag($event->getThumb(0),array('size'=>'100x100', 'alt'=>$event->getImage()->getCaption())); ?>
        <?php else : ?>  
            <?php echo image_tag('gui/default_event_'.$event->getCategory()->getId().'.jpg', 'size=100x100 style="height:96px" alt='.$event->getDisplayTitle()); ?>
        <?php endif;?>
    </a>

    <h3><a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo $event->getDisplayTitle();?>"><?php echo $event->getDisplayTitle();?></a></h3>
    
    <p>
        <?php if ($event->getDateTimeObject('start_at')->format('H:i:s') == '00:00:00') :  
            echo $event->getDateTimeObject('start_at')->format('d/m/Y');
        else:
            echo $event->getDateTimeObject('start_at')->format('d/m/Y H:i');
        endif; ?>
    </p>

    <p>
        <a href="<?php echo url_for('event/index?category_id='. $event->getCategoryId()) ?>" class="category"><?php echo $event->getCategory();?></a>
    </p>
</div>