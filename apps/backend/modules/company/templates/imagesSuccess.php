<div class="wrap">


<form id="posts-filter" action="" method="get">
<h2>Images for <?php echo $company ?> (<?php echo link_to('back', 'company/index') ?>)</h2>


<div class="tablenav">


<div class="alignleft">
<input type="submit" value="Delete" name="deleteit" class="button-secondary delete">

</div>

<br class="clear">
</div>

<br class="clear">

<table class="widefat">
  <thead>
  <tr>

  <th scope="col" class="check-column"><input type="checkbox"></th>
  <th scope="col"></th>
  <th scope="col">Media</th>
  <th scope="col">Description</th>
  <th scope="col">Date Added</th>
  <th scope="col" class="num"><div class="vers"><img alt="Comments" src="images/comment-grey-bubble.png"></div></th>
  <th scope="col">Location</th>

  </tr>
  </thead>
  <tbody id="the-list" class="list:post">
<?php foreach($images as $image): ?>
  <tr id="post-4" class="alternate author-self status-inherit" valign="top">

    <th scope="row" class="check-column"><input type="checkbox" name="delete[]" value="4"></th>
        <td class="media-icon">
          <a href="<?php echo $image->getThumb('preview') ?>" target="_blank"><?php echo image_tag($image->getThumb(), 'width=60') ?></a>
        </td>
        
        <td><strong><?php echo $image->getFile()->getFilename() ?></strong><br><?php echo $image->getFile()->getExtension() ?></td>
        <td><strong><?php echo link_to($image->getCaption(), 'image/edit?id='. $image->getId()) ?></strong></td>
        <td><?php echo $image->getDateTimeObject('created_at')->format('Y/m/d') ?></td>
        
        
          <td class="num"><div class="post-com-count-wrapper">
    <a href="upload.php?attachment_id=4" title="0 pending" class="post-com-count"><span class="comment-count">0</span></a>    </div></td>
        <td><a href="<?php echo $image->getFile()->getUrl() ?>" target="_blank">Permalink</a></td>
      </tr>
<?php endforeach ?>
  </tbody>
</table>

</form>
<br class="clear">



</div>

<br class="clear">

<div class="wrap">
  <h2>Add Image</h2>

  <form action="<?php echo url_for('company/images') ?>?id=<?php echo $company->getId() ?>" method="post" enctype="multipart/form-data">
    <?php //echo $form['_csrf_token'] ?>
    <table class="form-table">
      <tbody>
        <tr class="form-field form-required">
          <th scope="row" valign="top"><?php echo $form['caption']->renderLabel() ?></th>
          <td><?php echo $form['caption'] ?><br>
              The name is used to identify the category almost everywhere, for example under the post or in the category widget.</td>
      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><?php echo $form['file']->renderLabel() ?></th>
        <td><?php echo $form['file'] ?><br></td>
      </tr>
    </tbody></table>
  <p class="submit"><input type="submit" class="button" name="submit" value="Add Image"></p>
  </form>
</div>