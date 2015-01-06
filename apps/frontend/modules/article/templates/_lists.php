<?php 
	foreach ($articleLists as $articleList){
		include_partial('global/tag', array('id' => $articleList->getId(), 'text' => $articleList->getLists()->getTitle()));
	}
?>