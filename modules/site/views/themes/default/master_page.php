<!doctype html>
<html lang="en" class="no-js <?= $environment?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?= $title ?></title>
	<?php echo Component::factory('HeaderScripts'); ?>
</head>
<body>

	<nav>
		<?php echo Component::factory('PageNav', array(
			'parent_id' => 0
			)); ?>
	</nav>

	<div id="content">	
		<?php echo $content ?>
	</div>

	<div id="tags">
		<?php echo Component::factory('TagList', array())->render();?>
	</div>

	<footer>
		<!-- {execution_time} - {memory_usage} -->
		{profiler}
	</footer>

</body>
</html>

