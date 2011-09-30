<?php 
	echo 
	Component::factory('PageBody');
	echo 
	Component::factory('PageList', array(
		'parent_id' => $page->id,
	));
?>
