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
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Install Proxima CMS</title>
	<link type="text/css" rel="stylesheet" href="/media/proxima/css/install/install.css" />
	<style type="text/css">
	#install{position:static;width:654px;margin:3em auto;}
	</style>
</head>
<body>
	<div id="bg" class="tests">
		<div id="content">
			<div class="section tests">
				<fieldset>
					<h1>Environment Tests</h1>
					<p>
						The following tests have been run to determine if Kohana &amp; Proxima will work in your environment.
					</p>

					<?php

						$fail_msg = '✘ Kohana &amp; Proxima may not work correctly with your environment. Please fix the errors above before installing.';
						$pass_msg = '✔ Your environment passed all requirements. Please remove install.php before installing.';

						try
						{
							require CORPATH . 'views/page/install/tests/tests.php';
						}
						catch(Exception $e)
						{
							die('Error loading tests view');
						}
					?>
				</fieldset>
			</div>
		</div>
	</div>
</body>
</html>
