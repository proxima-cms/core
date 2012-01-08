<!DOCTYPE html>
<html lang="en" class="no-js admin <?php echo Kohana::$environment?> <?php echo Request::current()->controller()?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?></title>
	<?php echo HTML::style(Core::path('media/css/install/install.css')); ?>
	<?php echo HTML::script(Core::path('media/js/admin/libs/jquery/jquery-min.js')); ?>
</head>
<body>
	<div id="install">
		<div id="content">
		<?php echo $content ?>
	</div>
	<?php echo View::factory('admin/page/fragments/footer', array('paths' => $paths)) ?>
</body>
</html>
