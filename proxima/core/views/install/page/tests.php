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

<div class="container">
	<div class="row">
		<div class="span10 offset1 section tests">
		<h1>
			<?php echo HTML::anchor('install', __('Install'), array('style' => 'float:right;font-size:.6em;margin-top:4px;')); ?>
			Environment Tests
		</h1>
		<p>
			The following tests have been run to determine if Proxima CMS will work in your environment.
		</p><?php
			echo View::factory('install/page/tests/tests');
		?>
	</div>

</div>
</div>