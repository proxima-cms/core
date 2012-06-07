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

					<?php echo Proxima::admin_nav(); ?>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
