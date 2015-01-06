<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($category_article->getId(), 'category_article_edit', $category_article) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo '<strong>'.$category_article->getTitleByCulture('en').'</strong> <br />' ?>
  
    <?php $lang_array = array('bg','ro','mk','sr','fi', 'ru', 'hu', 'pt', 'me','ru');	 
	foreach ($lang_array as $lang):
	 echo '<strong>'.strtoupper($lang).'</strong> : '.$category_article->getTitleByCulture($lang).'<br />';
	endforeach;
 ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_status">
  <?php echo $category_article->getStatus() ?>
</td>
