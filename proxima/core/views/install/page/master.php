<!DOCTYPE html>
<html lang="en" class="no-js admin <?php echo Kohana::$environment?> <?php echo Request::current()->controller()?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title ?></title>
	<?php echo implode("\n\t", $assets->get('head')); ?>
	<style type="text/css">
	.help-inline{display:block !important;}
	body {padding:30px 0;}
	</style>
</head>
<body>
	<div class="container-fluid">
		<?php echo $content ?>
		<?php echo implode("\n\t", $assets->get('body')); ?>
	</div>
</body>
</html>
