<!DOCTYPE html>
<html lang="en" class="no-js admin <?php echo Kohana::$environment?> <?php echo Request::current()->controller()?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?></title>
	<?php echo implode("\n\t", array_map('HTML::style', $styles)), "\n";?>
	<?php echo implode("\n\t", array_map('HTML::script', $scripts)), "\n" ?>
	<style type="text/css">
		#content{width:354px;}
	</style>
</head>
	<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
	<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
	<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
	<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->

	<div id="messages">
		<div class="inner">
			<?php echo Message::render( new View('admin/message/basic') ) ?>
		</div>
	</div>

	<div id="content">
		<div id="inner">

			<?php echo $content ?>
	</div>

	<?php echo View::factory('admin/page/fragments/footer', array('paths' => $paths)) ?>
	</div>
	<script>
	if ($('#messages').find('li').length){
	$('#messages').fadeIn();
	setTimeout(function(){
		//$('#messages').fadeOut();
	}, 5000);
	}
	</script>
</body>
</html>
