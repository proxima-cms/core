<ul class="ui-menu">

	<?php
	$nav = Kohana::$config->load('admin/nav');
	$uri_segments = explode('/', Request::current()->uri());

	foreach($nav['links'] as $url => $page) {
		$classes = ($url === Request::current()->uri() OR $url === $uri_segments[0].'/'.@$uri_segments[1])
			? '' //' ui-state-focus ui-corner-all'
			: '';?>
		<li class="<?php echo $classes?>">
			<?php echo HTML::anchor($url, $page['text'])?>
			<?php if (isset($page['pages'])) {?>
			<ul>
				<?php foreach($page['pages'] as $p) {?>
					<li class="<?php echo $classes?>">
						<?php echo HTML::anchor($url, $p['text'])?>
					</li>
				<?php }?>
			</ul>
			<?php }?>
		</li>
	<?php }?>

	<li>
		<?php echo HTML::anchor('admin/auth/signout', 'Sign out')?>
	</li>
</ul>
