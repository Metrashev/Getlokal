<form action="<?php echo url_for('box/setup?id='. $box->getId()) ?>" method="post">
  <input type="hidden" name="xpath" value="<?php echo $sf_request->getParameter('xpath', ESC_RAW) ?>" />
  <div class="tablenav">

    <table cellspacing="0" cellpadding="3" align="left" width="100%"> 
      <tbody>
        <tr>
          <th align="left" width="150">Select categories:</th>
          <td align="left">
            <?php echo $form['ids'] ?>
          </td>
        </tr>
      </tbody>
    </table>
    <br clear="all"/>
    <input type="submit" id="post-query-submit" value="Save" class="button-secondary"/>
    <br class="clear"/>

  </div>
</form>

<div id="articleListing">
  <?php //include_component('boxconfig','articleListing'); ?>
</div>