<?php use_helper('I18N', 'Date') ?>
<?php include_partial('unregistered_newsletter_user/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Unregistered subscribers', array(), 'messages') ?></h1>

  <?php include_partial('unregistered_newsletter_user/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('unregistered_newsletter_user/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('unregistered_newsletter_user/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('unregistered_newsletter_user_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('unregistered_newsletter_user/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('unregistered_newsletter_user/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('unregistered_newsletter_user/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('unregistered_newsletter_user/list_footer', array('pager' => $pager)) ?>
      
    <?php if ($sf_user->hasAttribute('showForm') && $sf_user->getAttribute('showForm')) : ?>
        <form action="<?php echo url_for('@unregistered_newsletter_user'), '/importFromTxt' ?>" method="post" enctype="multipart/form-data">
            <input type="file" value="" name="txt" />
            <input type="submit" value="Send" />
        </form>
      
        <?php $sf_user->setAttribute('showForm', false); ?>
    <?php endif; ?>
  </div>
</div>
