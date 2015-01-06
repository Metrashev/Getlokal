<?php if (isset($events) && count($events)): ?>
<h5 class="gray">
    <strong><?php echo __('EVENTS') ?></strong> (<?php echo count($events); ?>)
</h5>
<div class="events">
    <?php foreach ($events as $e): ?>
        <a href="getlokal://event?<?php echo $e->getId(); ?>">
        <div class="event brd sh">
            <div class="row">
                <div class="col-xs-3">
                    <?php
                        $type = 'preview';
                        if ($e->getImage()->getType() != 'poster') {
                            $type = 2;
                        }
                        echo image_tag($e->getThumb($type), array(
                            'size' => '118x138',
                            'title' => $e->getDisplayTitle(),
                            'class' => 'img-responsive'
                        ));
                    ?>
                </div>
                <div class="col-xs-9">
                    <div class="row">
                        <div class="title">
                            <?php
                                // $url = url_for('dev/event') . sprintf('?token=%s&id=%d&lat=%s&long=%s&locale=%s',
                                //     $sf_request->getParameter('token'),
                                //     $e->getId(),
                                //     $sf_request->getParameter('lat'),
                                //     $sf_request->getParameter('long'),
                                //     $sf_request->getParameter('locale')
                                // );
                            ?>
                            <?php echo $e->getDisplayTitle(); ?>
                        </div>
                        <div class="price">
                        	<b><?php echo __("Ticket") ?>:</b>
                            <?php
                                if ($e->getPrice()) {
                                    echo $e->getPriceValue();
                                } else {
                                	echo __("FREE");
                                }
                            ?>
                        </div>
                        <div class="info">
                            <strong><?php echo $e->getUserProfile()->getSfGuardUser()->getFirstName(); ?></strong> -
                            <?php echo $e->getDateTimeObject('start_at')->format('d.m.Y'); ?>
                            <b> - <?php echo number_format($e->kms) . ' ' . __('km'); ?></b>
                        </div>
                        <div class="distance">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </a>
    <?php endforeach ?>
</div>
<?php endif; ?>
