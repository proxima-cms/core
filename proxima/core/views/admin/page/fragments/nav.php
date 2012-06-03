<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<div class="btn-group pull-right">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="icon-user"></i> <?php echo $username ?>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><?php echo HTML::anchor('admin/auth/profile', __('Profile'))?></li>
					<li class="divider"></li>
					<li><?php echo HTML::anchor('admin/auth/signout', __('Sign out'))?></li>
				</ul>
			</div>
			<div class="nav-collapse">
				<ul class="nav">
					<?php
					$nav = Kohana::$config->load('admin/nav');
					$uri_segments = explode('/', Request::current()->uri());

					foreach($nav['links'] as $url => $page) {
						
						$classes = ($url === Request::current()->uri() OR $url === $uri_segments[0].'/'.@$uri_segments[1])
							? 'active '
							: '';

						$classes .= isset($page['pages']) ? 'dropdown' : '';
						?>

						<li class="<?php echo $classes?>">
							<?php echo HTML::anchor(
								$url, 
								$page['text'].(isset($page['pages']) ? ' <b class="caret"></b>' : ''), 
								array(
									'data-toggle' => (isset($page['pages']) ? 'dropdown' : ''), 
									'class' => (isset($page['pages']) ? 'dropdown-toggle' : ''
								)))?>
							<?php if (isset($page['pages'])) {?>
							<ul class="dropdown-menu">
								<?php foreach($page['pages'] as $suburl => $p) {?>
									<li>
										<?php echo HTML::anchor($suburl, $p['text'])?>
									</li>
								<?php }?>
							</ul>
							<?php }?>
						</li>
					<?php }?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
