<form action="<?php echo url_for('event_category/classification?id='. $category->getId() ) ?>" method="post">
  
  <div class="wrap">
    <h2><?php echo $category->getTitle() ?> (<?php echo link_to('Category', 'event_category/classification?id='.$category->getId()) ?>)</h2>
    
			
    <table class="widefat">
      

        <tr class="alternate">
          <td>
          <?php echo $form['sector']->renderLabel()?>
			<?php echo $form['sector'] ?>
			<?php echo $form['sector']->renderError()?>
			
          <div class="options sector">
			<?php echo $form['classification_list']->renderLabel()?>
			<?php echo $form['classification_list'] ?>
			<?php echo $form['classification_list']->renderError()?>
			
          </div>
          </td>
        <td><label syle="display:inline" for="for_check" >Select All</label><input type="checkbox"  id="for_check"></td>  
 		<td><input type="submit" class="button" value="Save" /></td>
        </tr>
        </table>
    
    <br class="clear" />
  </div>
</form>

<script type="text/javascript">
$(document).ready(function() {
  $('#event_article_sector').change(function() {

	$('#for_check').removeAttr('checked');
	
	$.ajax({
	    url: "<?php echo url_for('event_category/addClassification');?>" ,
	    data: {sector_id: $(this).val(), category_id: <?php echo $category->getId()?>},
	    beforeSend: function( ) {
	      	$('.checkbox_list').html('<ul class="rcheckbox_list">loading...</ul>');
	      },
	    success: function( data ) {
	      $('.checkbox_list').html(data);
	    }
	  });
	
	
	 //$('.option.'+ $(this).val()).show();
  })

  $('#for_check').live('click', function() {
	  checked = $(this).attr('checked');
	  $('.checkbox_list li').each(function() {
		if (!$(this).hasClass('hidden')) {
			if (checked == 'checked')
				$(this).children('input').attr('checked', 'checked');
			else 
				$(this).children('input').removeAttr('checked');
		}
	  })
  })
})
</script>

<style>
.wrap h2{
border-bottom:none;
}
ul.checkbox_list li {
  float: left;
  width: 30%;
  margin-bottom: 4px;
}
ul.checkbox_list label{
display:inline;
}
</style>