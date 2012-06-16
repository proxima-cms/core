<!-- ACTIONS -->
<div class="well sidebar-nav">
	<ul class="nav nav-list">
		<li class="nav-header">Actions</li>
		<li>
			<?php echo HTML::anchor(
				Route::get('admin')
					->uri(array(
						'controller' => 'assets',
					)), __('View assets'));
			?>
		</li>
		<li>
			<?php echo HTML::anchor(
				Route::get('admin')
					->uri(array(
						'controller' => 'assets',
						'action' => 'upload',
					)), __('Upload assets'));
			?>
		</li>
	</ul>
</div>
