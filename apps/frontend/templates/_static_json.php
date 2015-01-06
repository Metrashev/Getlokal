<?php

	$gallery = array(
			array(
				'image'=>'/images/articles/picture1.png',
				'image_desc'=>'purva kartinka',
				'author_thumb'=>'/../css/images/lazi.jpg',
				'author_name'=>'Philip Lesov',
			),
			array(
				'image'=>'/images/articles/picture2.png',
				'image_desc'=>'vtora kartinka',
				'author_thumb'=>'/../css/images/lazi.jpg',
				'author_name'=>'Mitko Yugovski',
			),
			array(
				'image'=>'/images/articles/profile.png',
				'image_desc'=>'treta kartinka',
				'author_thumb'=>'/../css/images/lazi.jpg',
				'author_name'=>'Asdf',
			)  
		);

	echo json_encode($gallery);