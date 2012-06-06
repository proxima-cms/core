		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'tags', 
								'action' => 'add'
							)), __('Add tag'));?>
				</li>
			</ul>
	  </div><!--/.well -->
