<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($classification->getId(), 'classification_edit', $classification) ?>

</td>
<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo $classification->getTitle() ?></br>
  <?php $lang_array = array('bg','ro','mk','sr','fi', 'hu', 'pt','me','ru');
 foreach ($lang_array as $lang):
 $number = $classification->Translation[$lang]->number_of_places;
   echo '<strong>'.strtoupper($lang).'</strong> Number of Places: '.  $number.'</br>';
endforeach;
 ?>
</td>
<td class="sf_admin_text sf_admin_list_td_crm_id">
  <?php echo $classification->getCrmId() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_keywords">
  <?php echo $classification->getKeywords() ?>
</td>
