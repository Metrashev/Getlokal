<div class="slider_wrapper pp">
  <div class="slider-image">
    <div class="dim"></div>
  </div>
  <div class="slider-separator"></div>  
</div><!-- slider_wrapper -->

<div class="container set-over-slider">
    <div class="row"></div>
    </br></br></br></br>
    <div class="row">
        <div class="default-container default-form-wrapper col-sm-12">
          <p><?php  echo __('You need to log in with a user profile and not as a place admin in order to finish what you started.'); ?></p>
          <?php 
            if ($r=='create'){
              $sf_user->setAttribute('redirect_after_login', url_for('event/'.$r));
            } elseif ($r=='edit'){ 
              $sf_user->setAttribute('redirect_after_login', url_for('event/'.$r.'?id='.$id,true));
            }
              echo link_to(sprintf(__('Login as %s and '.ucfirst ($r).' an Event', null, 'user'), $sf_user->getGuardUser()->getUserProfile()) , 'companySettings/logout', array('class' => 'default-link'));
          ?>
        </br></br>
        </div>
    </div>
</div>