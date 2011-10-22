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
					<?php echo Component::factory('Tag_List');?>
				</div>
			</div>

			<div id="search">
			<form id="search-form" method="get" action="/search">
				<input type="hidden" value="badsyntax" name="t">
				<input type="hidden" value="all_of_tumblr" name="scope">
				<input type="text" value="" class="query" name="q">
				<input type="submit" class="submit" value="Search">
				<div class="clear"></div>
		</form>
	</div>

	<div class="widget twitter_feed" style="display:none">
		<h3>Latest Tweets</h3>
		<ul class="rss">
			<li>
				<a href="https://twitter.com/badsyntax/status/123804747080802304">
					TIL it's pretty much impossible to handle multi touch gestures in the Android browser (as they don't exist).		</a>
			</li>
			<li>
				<a href="https://twitter.com/badsyntax/status/121876163521032192">
					<a href="http://twitter.com/kohanaphp" target="_blank">@kohanaphp</a> hey, perhaps you are already aware, but the forums are down...		</a>
		
			</li>
			<li>
				<a href="https://twitter.com/badsyntax/status/120889217369899008">
					Having one of those frustrating days.. Gets to end of day and realize ive mostly been doing the wrong thing. <a href="http://twitter.com/search?q=%23fuckedoff" target="_blank">#fuckedoff</a>		</a>
			</li>
			<li>
					<a href="http://twitter.com/googledocs" target="_blank">@googledocs</a> its impossible to paste text into a google document on android. i reckon this is quite a big issue..		</a>
			</li>
		</ul>
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

	<?php echo
		Component::factory('Footer_Scripts');
	?>

</body>
</html>

