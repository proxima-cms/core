<?php
  echo 
	  Component::factory('Page_Body');
  
	echo 
	  Component::factory('Contact_Form', array(
			'recipient' => 'willis.rh@gmail.com',
			'subject' => 'New email from blog.badsyntax.co'
		));
?>
