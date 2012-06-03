<div class="row-fluid">
	<div class="span12">

		<div class="hero-unit">
			<h1>Dashboard</h1>
			<p>Welcome to the admin dashboard. This page gives an overview the features of this control panel.</p>
			<p><a class="btn btn-primary btn-large">Help &amp; docs &raquo;</a></p>
		</div>

		<div class="row-fluid">
			<div class="span4">
				<h2>Pages &amp; content</h2>
				<p>All content is managed by page.</p>
				<p>
				 <?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'pages')), __('Manage pages').' &raquo;', array('class' => 'btn'))?>
				</p>
			</div><!--/span-->
			<div class="span4">
				<h2>Users</h2>
				<p>Manage the users who are allowed to use this control panel. Users have set roles, and belong to groups.</p>
				<p>
				 <?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'users')), __('Manage users').' &raquo;', array('class' => 'btn'))?>
				</p>
			</div><!--/span-->
			<div class="span4">
				<h2>Assets</h2>
				<p>All site media files, including uploaded files, are classifed as an asset.</p>
				<p>
					<?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'assets')), __('Manage assets').' &raquo;', array('class' => 'btn'))?>
				</p>
			</div><!--/span-->
		</div><!--/row-->
		<div class="row-fluid">
			<div class="span4">
				<h2>Config</h2>
				<p>Manage your site configuration.</p>
				<p>
					<?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'config')), __('Manage config').' &raquo;', array('class' => 'btn'))?>
				</p>
			</div><!--/span-->
			<div class="span4">
				<h2>Maintenance</h2>
				<p></p>
				<p>
				 <?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'pages')), 'Manage pages', array('class' => 'btn'))?>
				</p>
			</div><!--/span-->
			<div class="span4">
				<h2>Modules</h2>
				<p>Modules are used to add or remove features from this site.</p>
				<p>
					<?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'modules')), __('Manage modules').' &raquo;', array('class' => 'btn'))?>
				</p>
			</div><!--/span-->
		</div><!--/row-->
	</div>
</div>
