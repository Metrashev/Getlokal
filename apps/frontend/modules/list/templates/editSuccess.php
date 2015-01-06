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
                <h1 class="col-xs-12 main-form-title"><?php echo __('Edit List',null,'list'); ?></h1>
            </div>
        </div>
    </div>
    <?php include_partial('form', array('form' => $form, 'user'=>$user, 'is_place_admin_logged' => $is_place_admin_logged)); ?>
</div>