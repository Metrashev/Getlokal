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
                <h3 class="col-xs-12 list-header"><?php echo __('Claim Your Company', null, 'company');?></h3>
            </div>
        </div>
    </div>
  </br></br>
    <div class="row">
        <div class="default-container default-form-wrapper col-sm-12">
          <p><?php echo sprintf(__('Your Place Claim for %s, %s  has already been rejected and you have been notified by email.', null, 'claim'), $company->getCompanyTitle(), $company->getDisplayAddress()); ?></p>
          <br /><br />
          <p><?php echo sprintf(__('If you have any questions, feel free to %s.',null,'claim'),link_to(__('contact us', NULL, 'claim'), 'contact/getlokal', array('title' => __('contact us', NULL, 'claim'))))?></p>
        </div>
    </div>
</div>