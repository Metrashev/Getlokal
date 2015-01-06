<div class="content_in">

  <h1><?php echo __('Report Abuse');?></h1>

    
  <form action="<?php echo url_for('report/image?id='.$image->getId(). '&modal='. $sf_request->getParameter('modal', 0)) ?>" method="post">
    <?php include_partial('form', array('form' => $form)) ?>
  </form>


</div>            