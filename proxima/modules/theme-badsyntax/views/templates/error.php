<!doctype html>
<html lang="en" class="no-js <?= $environment?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?><?php if(Kohana::$environment === Kohana::DEVELOPMENT){ echo ' - DEVELOPMENT'; }?></title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<!--
	<link rel="canonical" href="http://dev.blog.badsyntax.co/" />
	<link rel="alternate" type="application/rss+xml" title="BadSyntax" href="http://dev.blog.badsyntax.co/blog/rss/all.rss" />
	-->
	<link href="//fonts.googleapis.com/css?family=Orbitron:400,500,700,900|Cabin:bold,regular" rel="stylesheet" type="text/css" />
	<?php echo Component::factory('Head_Scripts'); ?>
	<?php if (Kohana::$environment === Kohana::DEVELOPMENT){?>
	<style>
	/*.kohana{display:none;}*/
	</style>
	<?php }?>
</head>
<body>
	<div id="container" class="clear">

		<header>
			<h1>
				<a href="/">
					BadSyntax
				</a>
			</h1>
		</header>

		<div id="content" role="main">
			<div class="box post">

				<h2 class="title"><?php echo $title; ?></h2>
		
			</div>
		</div>

	</div>

</body>
</html>
