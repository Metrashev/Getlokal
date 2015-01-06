<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($category->getId(), 'category_edit', $category) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo '<strong>'.$category->getTitleByCulture('en').'</strong> <br />' ?>
  
    <?php $lang_array = array('bg','ro','mk','sr', 'fi', 'ru', 'hu', 'pt', 'me', 'ru');
	 foreach ($lang_array as $lang):
	 echo '<strong>'.strtoupper($lang).'</strong> : '.$category->getTitleByCulture($lang).'<br />';
	endforeach;
 ?>
</td> 
