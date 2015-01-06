<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_edit">
    <?php echo link_to(__('Edit'), '/'. $sf_user->getCulture().'/d/article/edit/id/'.$article->getId(), array('target'=>'_blank') )  ?>
    </li>
    <?php //echo $helper->linkToEdit($article, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',))?>
    <?php echo $helper->linkToDelete($article, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
