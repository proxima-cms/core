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

						$has_dropdown = ( isset($page['pages']) || isset($page['groups']) );
						
						$classes .= $has_dropdown ? 'dropdown' : '';
						?>

						<li class="<?php echo $classes?>">
							<?php echo HTML::anchor(
								$url, 
								$page['text'] . ($has_dropdown ? ' <b class="caret"></b>' : ''), 
								array(
									'data-toggle' => ($has_dropdown ? 'dropdown' : ''), 
									'class' => ($has_dropdown ? 'dropdown-toggle' : '')
								))?>
							<?php if ($has_dropdown) {?>
							<ul class="dropdown-menu">
								<?php if(isset($page['groups'])){?>
									<?php foreach($page['groups'] as $group => $pages){?>
										<li class="nav-header"><?php echo ucfirst($group);?></li>
										<?php foreach($pages as $suburl => $p) {?>
											<li>
												<?php echo HTML::anchor($suburl, $p['text'])?>
											</li>
										<?php }?>
									<?php }?>
								<?php } else if (isset($page['pages'])){?>
									<?php foreach($page['pages'] as $suburl => $p) {?>
										<li>
											<?php echo HTML::anchor($suburl, $p['text'])?>
										</li>
									<?php }?>
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
