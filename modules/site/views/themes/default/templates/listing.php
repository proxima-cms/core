<?php echo $body?>

<?php 

	echo 
	Component::factory('PageList', array(
		'parent_id' => $page->id,
	))->render();
?>
