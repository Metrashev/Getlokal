<form action="<?php echo url_for('box/setupTest') ?>" method="post">
  <input type="hidden" name="xpath" value="<?php echo $sf_request->getParameter('xpath', ESC_RAW) ?>" />
  <div class="tablenav">

    <table cellspacing="0" cellpadding="3" align="left" width="100%"> 
      <tbody>
        <tr>
          <th align="left" width="150">Box Title:</th>
          <td align="left">
            <?php echo $form['title'] ?>
          </td>

        </tr>
      </tbody>
    </table>
    <br clear="all"/>
    <input type="submit" id="post-query-submit" value="Save" class="button-secondary"/>
    <br class="clear"/>

  </div>

  <div id="articleSelect">
  <h3>Selected Articles</h3>

  <div style="display: block;padding:0px;height:200px;margin:0px;" id="linkcategorydiv" class="ui-tabs-panel">

    <table class="widefat">
      <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Article</th>
          <th scope="col">action</th>
        </tr>
      </thead>
      <tbody id="node-list">
        <?php foreach ($nodes as $node): ?>
          <tr>
            <td>
              <?php echo image_tag($node->getMedia()->getThumb(), 'height=32') ?>
              <?php echo input_hidden_tag('nodes[]',$node->getId()) ?>
            </td>
            <td><?php echo $node->getTitle() ?></td>
            <td><a onclick="$(this.parentNode.parentNode).remove();return false;" href="#">Remove</a></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>

  </div>

</form>

<div id="articleListing">
  <?php //include_component('boxconfig','articleListing'); ?>
</div>