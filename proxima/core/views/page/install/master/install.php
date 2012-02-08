<!DOCTYPE html>
<html lang="en" class="no-js admin <?php echo Kohana::$environment?> <?php echo Request::current()->controller()?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?></title>
	<?php echo implode("\n\t", $assets->get('head')); ?>
</head>
<body>
	<?php echo $content, "\n" ?>
	<?php echo implode("\n\t", $assets->get('body')); ?>
</body>
</html>
