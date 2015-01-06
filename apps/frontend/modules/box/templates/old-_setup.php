<?php if($sf_user->hasCredential('edit')): ?>
  <?php if(!$sf_user->getAttribute('edit_mode', false)): ?>
    <div id="setupControl" style="position: fixed; top: 0; right: 0; padding: 10px; background: #eee;">
      <?php echo link_to('Edit', 'box/enterSetup') ?>
    </div>
  <?php else: ?>
  
<?php use_javascript('tools.js') ?>

<div id="setupControl" style="position: fixed; top: 0; right: 0; padding: 10px; background: #eee;">
  <form action="<?php echo url_for('box/save') ?>" method="post">
    <input type="hidden" name="values" value="" id="setup_values" />
    <input type="hidden" name="key" value="<?php echo $key ?>" id="setup_key" />
    <input type="submit" />
  </form>
</div>

<div id="setup" class="sortable">
  <?php foreach($boxes as $box): ?>
    <div class="box">
      <?php include_component($box->getBox()->getModule(), 'box'. ucfirst($box->getBox()->getComponent()), array('box' => $box)) ?>
      <?php include_partial('box/box_setup', array('box' => $box)) ?>
    </div>
  <?php endforeach ?>
  
  <div class="clear"></div>
</div>

<script type="text/javascript">
function updateBox(xpath, settings)
{
  var element = $(xpath);

  $.ajax({
    url     : '<?php echo url_for('box/load') ?>',
    method  : 'post',
    data    : 'settings='+ settings+ '&box_id='+ $(element).find('.box_id').val(),
    success : function(data) {
      $(xpath).html($(data).html());
      
      init();
    }
  });
  
  $.fancybox.close();
}
function init()
{
  cols = {1: [], 2: []};
  $('#middleColumn .box').each(function(i,s) {
    console.log(s);
    cols[1][i] = { id: $(s).find('.box_id').val(), settings: $(s).find('.box_settings').val(), key: $(s).find('.col_key').val() };
  });
  
  $('#rightColumn .box').each(function(i,s) {
    cols[2][i] = { id: $(s).find('.box_id').val(), settings: $(s).find('.box_settings').val(), key: $(s).find('.col_key').val() };
  });
  
  $('#setup_values').val(Base64.encode(serialize(cols)));
      
  $( ".box .lightbox_setup" ).each(function(i, s) {
    
    $(s).fancybox({
      type  : 'iframe',
      width : 800,
      height: 600,
      href  : $(s).attr('href')+ '?settings='+ $(s).parent().parent().find('.box_settings').val()+ '&xpath='+ getXPath($(s).parent().parent()[0]),
      ajax  : {
          type  : "POST",
          data  : 'settings='+ $(s).parent().parent().find('.box_settings').val()+ '&xpath='+ getXPath($(s).parent().parent()[0])
      }
    });
  });
}
  
$(document).ready(function() {
  
  $( "#rightColumn, #middleColumn" ).addClass('sortable').disableSelection();
    
  $( "#setup, #rightColumn, #middleColumn" ).sortable({
    connectWith : ".sortable",
    items       : '.box',
    over        : function(event, ui) {
      $(ui.item).width($(event.target).width());
    },
    update      :  function(event, ui) {
      
      if(event.target.id == 'setup' && $(ui.item).parent().attr('id') != 'setup')
      {
        console.log(ui.item);
        $(ui.item).clone().appendTo('#setup');
      }
      
      init();
    }
  });
  
  init();
})
</script>
<?php endif; endif ?>