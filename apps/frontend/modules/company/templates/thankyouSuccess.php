<!-- <div id="success-msg"> 
    <div class="wrapper-thanks">
        <h2><?php //echo __('Thank you', null, 'company'); ?></h2> 
        <div id="actions">
            <?php //echo link_to(__('Add other place'), 'company/addCompany', array('title' => __('Add other place')));?>
        </div>
    </div>
</div> -->

<div class="slider_wrapper pp">
  <div class="slider-image">
    <div class="dim"></div>
  </div>
  <div class="slider-separator"></div>  
</div><!-- slider_wrapper -->

<div class="container set-over-slider">
    <div class="row">
        <div class="container">
            <div class="row">
                <h2><?php echo __('Thank you', null, 'company'); ?></h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="default-container default-form-wrapper col-sm-12">
          <?php echo link_to(__('Add other place'), 'company/addCompany', array('title' => __('Add other place')));?>
        </div>
    </div>
</div>