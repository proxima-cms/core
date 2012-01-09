<?php

// Sanity check, install should only be checked from index.php
defined('SYSPATH') or exit('Install tests must be loaded from within index.php!');

if (version_compare(PHP_VERSION, '5.3', '<'))
{
	// Clear out the cache to prevent errors. This typically happens on Windows/FastCGI.
	clearstatcache();
}
else
{
	// Clearing the realpath() cache is only possible PHP 5.3+
	clearstatcache(TRUE);
}

?>

<div id="install" class="tests">
	<div id="content">
		<div class="section tests">
			<?php echo Form::open('install', array('method' => 'get', 'id' => 'install-redirect')); ?>
				<fieldset>
					<h1>
						<?php echo HTML::anchor('install', __('Install'), array('style' => 'float:right;font-size:.6em;margin-top:4px;')); ?>
						Environment Tests
					</h1>
					<p>
						The following tests have been run to determine if Proxima CMS will work in your environment.
					</p>
					<?php
						$fail_msg = '✘ Proxima &amp; Kohana may not work correctly with your environment. Please fix the errors above before installing.';
						$pass_msg = '✔ Your environment passed all requirements.';
						try
						{
						require_once('modules/core/views/page/install/tests/tests.php');
						}
						catch(Exception $e)
						{
							die('Error loading tests view');
						}
					?>
			</fieldset>
			<?php echo Form::submit('i', __('Install'), array('class' => 'ui-button default'))?>
			<?php echo Form::close()?>
		</div>
	</div>
</div>
