<!DOCTYPE html>
<html lang="en" class="no-js admin <?php echo Kohana::$environment?> <?php echo Request::current()->controller()?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title ?></title>
	<?php echo implode("\n\t", $assets->get('head')); ?>
</head>
<body>

	<?php echo View::factory('admin/page/fragments/header', array('username' => $username)) ?>

	<div class="container-fluid">
		<?php echo View::factory('admin/page/fragments/messages') ?>
		<?php echo View::factory('admin/page/fragments/content', array('content' => $content, 'breadcrumbs' => $breadcrumbs)) ?>
		<?php echo View::factory('admin/page/fragments/footer') ?>
	</div>

	<?php echo implode("\n\t", $assets->get('body')); ?>
</body>
</html>
