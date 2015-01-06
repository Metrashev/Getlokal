<?php foreach ($classifications as $classification): ?>

<li>
	<input <?php echo $classification->getClassificationId() ? 'checked="checked"':'' ?>  name="event_article[classification_list][]" type="checkbox" value="<?php  echo $classification->getId(); ?>" id="event_article_classification_list_<?php  echo $classification->getId(); ?>">&nbsp;
	<label for="classification_list_<?php  echo $classification->getId(); ?>"><?php  echo $classification->getTitle(); ?></label>
</li>


<?php endforeach;?>

<?php foreach ($category_classifications as $cat_clas): ?>

<li style="display:none" class="hidden" >
	<input checked="checked"  name="event_article[classification_list][]" type="checkbox" value="<?php  echo $cat_clas->getClassificationId(); ?>" id="event_article_classification_list_<?php  echo $cat_clas->getClassificationId(); ?>">&nbsp;
	<label for="classification_list_<?php  echo $cat_clas->getClassificationId(); ?>"><?php  echo $cat_clas->getClassification()->getTitle(); ?></label>
</li>


<?php endforeach;?>