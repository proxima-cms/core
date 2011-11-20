<nav class="second-level">
	
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		
		<?php
		$nav = Kohana::$config->load('admin/nav');
		$uri_segments = explode('/', Request::current()->uri());

		foreach($nav['links'] as $url => $text) {				
			$classes = ($url === Request::current()->uri() OR $url === $uri_segments[0].'/'.@$uri_segments[1])
				? ' ui-tabs-selected ui-state-active'
				: '';?>
			<li class="ui-state-default ui-corner-top<?php echo $classes?>"><?php echo HTML::anchor($url, $text)?></li>
		<?php }?>
		
		<li class="ui-state-default ui-corner-top ui-helper-right">
			<?php echo HTML::anchor('admin/auth/signout', 'Sign out')?>
		</li>
	</ul>
</nav>
