<?php if ($company->getNumberOfReviews()): ?>
<h5 class="gray">
    <strong><?php echo __('REVIEWS') ?></strong> (<?php echo $company->getNumberOfReviews() ?>)
</h5>
<div class="wrap reviews brd">
    <?php foreach ($reviews as $r): ?>
     <!-- <a href="getlokal://goToUserProfile?<?php echo $r->getUserId() ?>"> -->
        <div class="review clearfix">
            <div class="col-xs-3 image">
                <?php echo image_tag($r->getUserProfile()->getThumb(0), array(
                    'size' => '36x36',
                    'class' => 'img-responsive'
                )); ?>
            </div>
            <div class="col-xs-9">
                <div class="row">
                    <div class="pull-left name"><?php echo $r->getUserProfile(); ?></div>
                    <div class="pull-right date">
                        <?php echo $r->getDateTimeObject('created_at')->format('d.m.Y'); ?>
                    </div>
                </div>
                <div class="row">
                    <?php include_partial('rating', array('value' => $r->getRatingProc())); ?>
                </div>
                <div class="row text">
                    <?php echo $r->getText(ESC_RAW); ?>
                    <?php $answers = $r->getAnswers(); ?>
                    <?php if ($answers): ?>
                        <?php foreach ($answers as $a): ?>
                            <div class="answer">
                                <div class="row">
                                    <div class="col-xs-3 image">
                                        <?php echo image_tag($a->getUserProfile()->getThumb(0), array(
                                            'size' => '36x36',
                                            'class' => 'img-responsive'
                                        )); ?>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="row">
                                            <div class="pull-left name"><?php echo $a->getUserProfile(); ?></div>
                                            <div class="pull-right date">
                                                <?php echo $a->getDateTimeObject('created_at')->format('d.m.Y'); ?>
                                            </div>
                                        </div>
                                        <div class="row text"><?php echo $a->getText(ESC_RAW); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
     <!-- </a>    -->
    <?php endforeach ?>
</div>

<?php endif ?>
