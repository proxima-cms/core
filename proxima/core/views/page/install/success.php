<div id="bg">
	<div id="content">
		<p id="results" class="pass">Install successfull!</p>
		<p>
		<?php
			// Show a demo migration result if no migration speciifed (debug)
			echo isset($migration) ? nl2br(trim($migration)) : '
			Executed 2 migrations<br>
			<br>
			Current versions of groups:<br>
			 * install 20120102113535 (add-lang-field-to-users-table)'; ?>
		</p>
		<p><big><strong>Proxima CMS is now installed.</strong></big></p>
		<p style="margin-bottom:.6em">
			  <a href="<?php echo URL::site(Route::get('install')->uri(array('action' => 'disable'))) . '?return_to=admin';?>" class="btn signin">
				<span></span>
				Sign in
			</a>
		</p>
	</div>
</div>
