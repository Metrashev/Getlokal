
<?php if($items->count()>0):?>
<div id="slider1_container" style="width: 600px;height: 294px;">
        <?php // Loading Screen ?>
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(/images/gui/loader-slider.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%; border-radius: 3px;">
            </div>
        </div>
        
        <?php //  Slides Container ?>
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 600px; height: 294px;
            overflow: hidden;">
       
             <?php foreach ($items as $item): ?>
             
                    <?php if (!$item->getLink(ESC_RAW)) continue; ?>
                <div>
                    <?php echo link_to(image_tag($item->getThumb(), array('alt' => $item->getTitle(), 'u'=>'image', 'size' => '600x294')), $item->getLink(ESC_RAW)) ?>
                    <?php if($item->getTitle() or $item->getBody() ):?>
                    <div class="captionOrange"  style="position:absolute; left:0px; top: 0px; width:310px;">
                          <?php if($item->getTitle()):?>
                            <?php echo link_to($item->getTitle(), $item->getLink(ESC_RAW)) ?>
                          <?php endif;?>
                          <?php if($item->getBody()):?>
                             <p><?php echo $item->getBody() ?></p>
                          <?php endif;?>
                    </div>
                    <?php endif;?>
                 </div>
         
             <?php endforeach ?>
            
        </div>
        <?php // bullet navigator container ?>
        <div u="navigator" class="jssorb01">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="POSITION: absolute; WIDTH: 12px; HEIGHT: 12px;"></div>
        </div>

        <span u="arrowleft" class="jssora21l" style="POSITION: absolute;width: 40px; height: 40px; top: 150px; left: 10px;">
            <i class="fa fa-chevron-left"></i>
        </span>

        <span u="arrowright" class="jssora21r" style="POSITION: absolute;width: 40px; height: 40px; top: 150px; right: -2px;">
            <i class="fa fa-chevron-right"></i>
        </span>

    </div>
    <?php echo javascript_include_tag(javascript_path('jssor/jssor.core.js')) ?>   
    <?php echo javascript_include_tag(javascript_path('jssor/jssor.utils.js')) ?>
    <?php echo javascript_include_tag(javascript_path('jssor/jssor.slider.js')) ?>
    <?php echo javascript_include_tag(javascript_path('carousel.jssor.js')) ?>
<?php endif ?>