<!doctype html>
<html lang="en" class="no-js <?= $environment?>" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $page->title ?><?php if(Kohana::$environment === Kohana::DEVELOPMENT){ echo ' - DEVELOPMENT'; }?></title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<!--
	<link rel="canonical" href="http://dev.blog.badsyntax.co/" />
	<link rel="alternate" type="application/rss+xml" title="BadSyntax" href="http://dev.blog.badsyntax.co/blog/rss/all.rss" />
	-->
	<?php echo implode("\n\t", $assets->get('head')); ?>

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
			<?php echo $content ?>
		</div>

		<div id="sidebar">

			<div id="site_navigation" class="box clear">
				<div id="avatar">
					<a href="/">
						BadSyntax
					</a>
				</div>

				<h4>Pages</h4>

				<div class="nav">
				<nav>
					<?php echo Component::factory('Page_Nav', array(
						'parent_id' => 233
						)); ?>
				</nav>
			</div>

				<h4>Tags</h4>

			<div class="nav">
				<div id="tags">
					<ul>
						<li><?php echo HTML::anchor('tag/bash', 'Bash'); ?></li>
						<li><?php echo HTML::anchor('tag/dubstep', 'Dubstep'); ?></li>
						<li><?php echo HTML::anchor('tag/git', 'Git'); ?></li>
						<li><?php echo HTML::anchor('tag/Javascript', 'Javascript'); ?></li>
						<li><?php echo HTML::anchor('tag/jquery', 'jQuery'); ?></li>
						<li><?php echo HTML::anchor('tag/kohana', 'Kohana'); ?></li>
						<li><?php echo HTML::anchor('tag/php', 'PHP'); ?></li>
						<li><?php echo HTML::anchor('tag/vim', 'Vim'); ?></li>
					</ul>
					<?php /* echo Component::factory('Tag_List');*/?>
				</div>
			</div>

			<div id="search">
			<form id="search-form" method="get" action="/search">
				<input type="text" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'query')); ?>" class="query" name="query">
				<input type="submit" class="submit" value="Search">
				<div class="clear"></div>
		</form>
	</div>


	<div class="widget twitter_feed">
		<h3>Latest Tweets</h3>
		<?php echo Component::factory('SocialMedia_Twitter', array('username' => 'badsyntax'))?>
	</div>

</div>
<div class="box banner clear">
	<a title="Pravda23 - Update Your Music" href="http://pravda23.com">
		<img alt="Pravda23 - Update Your Music" src="http://badsyntax.co/img/pravda23_banner.jpg">
	</a>
</div>
<div class="box banner clear">
	<a title="JavaScript API" href="https://developer.mozilla.org/en/JavaScript">
		<img width="180" height="150" alt="JavaScript API" src="/application/views/<?php echo Theme::path('media/img/promotejsh.gif')?>">
	</a>
</div>
<!--
<div class="box banner clear">
	<a title="Ubuntu: next stable release" href="http://www.ubuntu.com/">
		<img width="180" height="150" alt="Ubuntu" src="http://ubuntu.badsyntax.co/countdown/stable">
	</a>
</div>
-->

<div style="color:#666;font-size:.8em;text-align:center;margin-bottom:1em;">Powered by <a href="http://kohanaframework.org/">Kohana 3.2</a></div>

		</div>

		<footer>
		</footer>
	</div>

	<?php echo implode("\n\t", $assets->get('body')); ?>
</body>
</html>

