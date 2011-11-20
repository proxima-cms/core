<!doctype html>
<html lang="en" class="no-js <?= $environment?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?= $title ?></title>
	<?php echo Component::factory('Head_Scripts'); ?>
</head>
<body>

	<nav>
		<?php echo Component::factory('Page_Nav', array(
			'parent_id' => 0
			)); ?>
	</nav>

	<div id="content">	
		<?php echo $content ?>
	</div>

	<div id="tags">
		<?php echo Component::factory('Tag_List');?>
	</div>

	<footer>
		<?php echo
			Component::factory('Footer_Scripts');
		?>
	</footer>

</body>
</html>

