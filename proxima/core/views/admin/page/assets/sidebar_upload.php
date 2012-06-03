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

<!-- SEARCH -->
<div class="well sidebar-nav">
	<ul class="nav nav-list">
		 <li class="nav-header">Search</li>
		 <li>
	<?php echo Form::open(Route::get('admin')->uri(array('controller' => 'assets')), array('class' => 'ui-helper-clearfix', 'style' => 'padding-bottom:6px'))?>
	<div class="input-append">
		<?php echo Form::input('search', NULL, array('class' => 'helper-left', 'style' => 'width: 150px'))?>
		<?php echo Form::button('search-submit', 'Go', array('class' => 'btn'))?>
		</div>
	<?php echo Form::close()?>
	</li>
	</ul>
</div>
