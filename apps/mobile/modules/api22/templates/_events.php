<?php if (isset($events) && count($events)): ?>
<h5 class="gray">
    <strong><?php echo __('EVENTS') ?></strong> (<?php echo count($events); ?>)
</h5>
<div class="events">
    <?php foreach ($events as $e): ?>
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
                                $url = url_for('dev/event') . sprintf('?token=%s&id=%d&lat=%s&long=%s&locale=%s',
                                    $sf_request->getParameter('token'),
                                    $e->getId(),
                                    $sf_request->getParameter('lat'),
                                    $sf_request->getParameter('long'),
                                    $sf_request->getParameter('locale')
                                );
                            ?>
                            <a href="<?php echo $url; ?>"><?php echo $e->getDisplayTitle(); ?></a>
                        </div>
                        <div class="info">
                            <strong><?php echo $e->getUserProfile()->getSfGuardUser()->getFirstName(); ?></strong> -
                            <?php echo $e->getDateTimeObject('start_at')->format('d/m/Y'); ?>
                        </div>
                        <div class="price">
                            <?php
                                if ($e->getPrice() != 0) {
                                    echo $e->getPriceValue($e->getCountry()->getCurrency());
                                }
                            ?>
                        </div>
                        <div class="distance">
                            <?php echo __('Distance'); ?> -
                            <?php echo number_format($e->kms); ?>
                            <?php echo __('km'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php endif; ?>
