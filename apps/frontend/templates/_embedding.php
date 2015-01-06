<?php
if (!isset($embed))
{
  return;
}
?>
<?php
  $class = '';
  switch ($embed) {
    case 'place':
      $widget_url = url_for(sprintf('@widget?action=place&id=%s', $company->getId()), true);
      break;
    case 'events':
      $class = 'large';
      $widget_url = url_for('@widget?action=events', true);
      break;
  }
?> 
 								<div class="embed-holder">
                  <a id="toggle-embed-btn" href="javascript:void(0)" class="default-btn small btn-embed"><?= __('Embed') ?> <i id="toggle-caret" class="fa fa-angle-down"></i></a>
  								<div id="wrap-popover" style="display:none;" class="popover-embed-btn">
  								<div class="popover-arrow-embed-btn"></div>
  									<div class="wrapper-embed-btn">
  										
                    <div class="embedding <?php echo $class ?>" data-type="<?php echo $embed ?>" data-url="<?php echo $widget_url ?>">
                      <div class="box">
                        <div class="c">
                            <div class="widget_description">
                              <?php if($sf_params->get('module') == 'event' && ($sf_params->get('action') == 'recommended' || $sf_params->get('action') == 'index')):?>
                                <h1><?php echo __('Events Widget',null,'messages');?></h1>
                                <?php echo __('Do you run a events related blog or website? You can take-away some fresh content from getlokal. Just customize the looks and content, grab the code and paste it in the source code where you want it to show.',null,'messages');?>
                              <?php elseif($sf_params->get('module') == 'company' && $sf_params->get('action') == 'show'):?>
                                <h1><?php echo __('Place Widget',null,'messages');?></h1>
                                <?php echo __('If you just want to grab this place details and show them on your blog or site, just customise the settings below and paste the code in your source file.',null,'messages');?>
                              <?php endif;?>
                            </div>

                          <?php $form = new EmbedWidgetForm(array(), compact('embed')); ?>
                          <div class="l">
                            <?php echo $form->renderPropFields(); ?>
                          </div>
                          <div class="r">
                            <div class="input code">
                              <?php echo $form['code']->renderRow(); ?>
                            </div>
                          </div>
                          <div class="cl"></div>
                        </div>
                      </div>
                    </div>










                     <!--  <ul class="content-embed-btn col-sm-12">
  										<?php if($sf_params->get('module') == 'event' && ($sf_params->get('action') == 'recommended' || $sf_params->get('action') == 'index')) { ?>
  								            <li>
  								            	<h1><?= __('Events Widget',null,'messages');?></h1>
  								            </li>
  								            <li>
  								            	<p><?= __('Do you run a events related blog or website? You can take-away some fresh content from getlokal. Just customize the looks and content, grab the code and paste it in the source code where you want it to show.',null,'messages');?></p>
  										    </li>
  										<?php } elseif($sf_params->get('module') == 'company' && $sf_params->get('action') == 'show') {?>
  								            <li>
  								            	<h1><?= __('Place Widget',null,'messages');?></h1>
  								            </li>
  								            <li>
  								            	<p><?= __('If you just want to grab this place details and show them on your blog or site, just customise the settings below and paste the code in your source file.',null,'messages');?></p>
  										    </li>
  								        <?php } ?>
  										  	<li>
  										  		<?php $form = new EmbedWidgetForm(array(), compact('embed')); ?>
  											      <div class="l">
  											          <?php echo $form->renderPropFields(); ?>
  											      </div>
  											      <div class="r">
  											        <div class="input code">
  											          <?php echo $form['code']->renderRow(); ?>
  											        </div>
  											      </div>
  											      <div class="cl"></div>
  										  	</li>
  										</ul> -->
  									
                    </div>
  								</div>
                </div>
								
<!--					
<div class="embedding <?php echo $class ?>" data-type="<?php echo $embed ?>" data-url="<?php echo $widget_url ?>">
  <div class="margin-top" style="padding-bottom: 10px;">
    <a href="#" class="btn button_pink"><?php echo __('Embed') ?></a>
  </div>
  <div class="box">
    <div class="c">
        <div class="widjet_description">
          <?php if($sf_params->get('module') == 'event' && ($sf_params->get('action') == 'recommended' || $sf_params->get('action') == 'index')):?>
            <h4><?php echo __('Events Widget',null,'messages');?></h4>
            <?php echo __('Do you run a events related blog or website? You can take-away some fresh content from getlokal. Just customize the looks and content, grab the code and paste it in the source code where you want it to show.',null,'messages');?>
          <?php elseif($sf_params->get('module') == 'company' && $sf_params->get('action') == 'show'):?>
            <h4><?php echo __('Place Widget',null,'messages');?></h4>
            <?php echo __('If you just want to grab this place details and show them on your blog or site, just customise the settings below and paste the code in your source file.',null,'messages');?>
          <?php endif;?>
        </div>

      <?php $form = new EmbedWidgetForm(array(), compact('embed')); ?>
      <div class="l">
        <?php echo $form->renderPropFields(); ?>
      </div>
      <div class="r">
        <div class="input code">
          <?php echo $form['code']->renderRow(); ?>
        </div>
      </div>
      <div class="cl"></div>
    </div>
  </div>
</div> -->