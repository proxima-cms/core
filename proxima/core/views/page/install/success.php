<div id="install">
	<div id="content">
		<div class="section install">
			<p id="results" class="pass">Install successfull!</p>
			<p>
			<?php echo isset($migration) ? nl2br(trim($migration)) : '
				Executed 2 migrations<br>
				<br>
				Current versions of groups:<br>
				 * install 20120102113535 (add-lang-field-to-users-table)'; ?>
			</p>
			<p>Proxima CMS is now installed.</p>
			<p>
				<a href="<?php echo URL::site(Route::get('admin')->uri(array('controller' => 'auth', 'action' => 'signin'))); ?>" class="btn signin">
					<span></span>
					Sign in
				</a>
				<!--<?php echo HTML::anchor('', __('Home'), array('class' => 'btn'));?>-->
			</p>
		</div>
	</div>
</div>