<!doctype html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo $title;?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="/<?php echo Theme::path('css/style.css', TRUE, 'newadmin')?>">
	<link rel="stylesheet" href="/<?php echo Theme::path('css/bootstrap.css', TRUE, 'newadmin')?>">
	<link rel="stylesheet" href="/<?php echo Theme::path('css/admin.css', TRUE, 'newadmin')?>">
</head>
<body>

	<header>
		<?php echo Theme::view('fragments/header', FALSE, 'newadmin');?>
	</header>

	<div id="container">
		<div class="container-fluid">

			<div class="sidebar">
				<?php echo $sidebar; ?>
			</div>

			<div id="main" class="content" role="main">
				<?php echo $content; ?>
			</div>

			<footer>
				<?php echo Theme::view('fragments/footer', FALSE, 'newadmin');?>
			</footer>

		</div>
	</div>

</body>
</html>
