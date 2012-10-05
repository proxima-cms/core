<!DOCTYPE html>
<html lang="en" class="<?= Kohana::$environment === Kohana::DEVELOPMENT ? 'dev' : 'prod'?>" dir="ltr">
<head>
  <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $page->title ?><?php if(Kohana::$environment === Kohana::DEVELOPMENT){ echo ' - DEVELOPMENT'; }?></title>
	<meta name="description" content="<?php echo $page->description; ?>" />
	<meta name="viewport" content="width=device-width" />
	<script>__start=(new Date).getTime();document.documentElement.className+=' js';</script>
	<!--
	<link rel="canonical" href="http://dev.blog.badsyntax.co/" />
	<link rel="alternate" type="application/rss+xml" title="BadSyntax" href="http://dev.blog.badsyntax.co/blog/rss/all.rss" />
	-->
	<?php echo implode("\n\t", $assets->get('head')); ?>
</head>
<body>
	<?php echo $page->component('page/nav')->render(); ?>
	<div class="container">
  	<div class="row-fluid">
    	<div class="posts span9">
				<?php echo $content ?>
			</div>
			<div class="span3">
			 <div id="sidebar">
        <div class="well" style="padding:8px 0">
          <ul class="nav nav-list">
            <li class="nav-header">
              Popular tags
            </li>
					<?php echo $page->component('tag/list')->render(); ?>
					<!--
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
					-->
				</div>
				<div class="well">
					<div id="search">
						<form id="search-form" method="get" action="/search">
							<input type="text" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'query')); ?>" class="query" name="query">
							<input type="submit" class="submit" value="Search">
							<div class="clear"></div>
						</form>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<footer class="container" style="display:none">
		{profiler}
	</footer>
	<?php echo implode("\n\t", $assets->get('body')); ?>
</body>
</html>