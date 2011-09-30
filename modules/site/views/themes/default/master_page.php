<!doctype html>
<html lang="en" class="no-js <?= $environment?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?= $title ?></title>
	<?= implode("\n\t", array_map('HTML::style', $styles)), "\n";?>
	<?= implode("\n\t", array_map('HTML::script', $scripts)), "\n" ?>
	<script>(function(d,c){d[c]=d[c].replace(/\bno-js\b/, "js");})(document.documentElement,"className");</script>
</head>
<body>

	<?php echo View::factory($theme.'fragments/nav'); ?>

	<div id="content">	
		<?= $content ?>
	</div>

	<div id="tags">
		<?php echo Component::factory('TagList', array())->render();?>
	</div>

	<!-- {execution_time} - {memory_usage} -->
</body>
</html>

