<?php 
function test($test, $heading, $success_msg, $error_msg) {
	if ($test) {
		echo '<tr class="success"><th>'.$heading.'</th><td><i class="icon-ok"></i> '.$success_msg.'</td></tr>';
	} else {
		echo '<tr class="error"><th>'.$heading.'</th><td><i class="icon-remove"></i> '.$error_msg.'</td></tr>';
	}
}
?>
<table class="table">
		<?php 
		test(
			version_compare(PHP_VERSION, '5.2.3', '>='),
			'PHP Version',
			PHP_VERSION,
			'Kohana requires PHP 5.2.3 or newer, this version is '. PHP_VERSION
		);
		test(
			is_dir(SYSPATH) AND is_file(SYSPATH.'classes/kohana'.EXT),
			'System Directory',
			SYSPATH,
			'The configured <code>system</code> directory does not exist or does not contain required files.'
		);
		test(
			is_dir(APPPATH) AND is_file(APPPATH.'bootstrap'.EXT),
			'Application directory',
			APPPATH,
			'The configured <code>application</code> directory does not exist or does not contain required files'
		);
		test(
			is_dir(APPPATH) AND is_dir(APPPATH.'cache') AND is_writable(APPPATH.'cache'),
			'Cache Directory',
			APPPATH.'cache/',
			'The <code>'.APPPATH.'cache/</code> directory is not writable.'
		);
		test(
			is_dir(APPPATH) AND is_dir(APPPATH.'logs') AND is_writable(APPPATH.'logs'),
			'Logs Directory',
			APPPATH.'logs/',
			'The <code>'.APPPATH.'logs/</code> directory is not writable.'
		);
		test(
			is_dir(DOCROOT.'media') AND is_writable(DOCROOT.'media'),
			'Media Directory',
			DOCROOT.'media/',
			'The <code>'.DOCROOT.'media/</code> directory is not writable.'
		);
		test(
			is_dir(DOCROOT.'/media/assets') AND is_writable(DOCROOT.'media/assets'),
			'Assets Directory',
			DOCROOT.'media/assets',
			'The <code>'.DOCROOT.'media/assets</code> directory is not writable.'
		);
		test(
			is_dir(DOCROOT.'/media/assets/resized') AND is_writable(DOCROOT.'media/assets/resized'),
			'Assets Resized Directory',
			DOCROOT.'media/assets/resized',
			'The <code>'.DOCROOT.'media/assets/resized</code> directory is not writable.'
		);
		test(
			is_dir(DOCROOT.'/media/cache') AND is_writable(DOCROOT.'media/cache'),
			'Media Cache Directory',
			DOCROOT.'media/cache',
			'The <code>'.DOCROOT.'media/cache</code> directory is not writable.'
		);
		test(
			is_dir(APPPATH.'config') AND is_file(APPPATH.'config/modules.php') AND is_writable(APPPATH.'config/modules.php'),
			'Modules config file',
			APPPATH.'config/modules',
			'The <code>'.APPPATH.'config/modules.php</code> file is not writable.'
		);
		test(
			is_dir(CORPATH.'config') AND is_dir(CORPATH.'config/admin') AND is_file(CORPATH.'config/admin/nav.php') AND is_writable(CORPATH.'config/admin/nav.php'),
			'Admin nav config file',
			CORPATH.'config/admin/nav.php',
			'The <code>'.CORPATH.'config/admin/nav.php</code> file is not writable.'
		);
		test(
			@preg_match('/^.$/u', 'ñ'),
			'PCRE UTF-8 ',
			'Pass',
			'<a href="http://php.net/pcre">PCRE</a> has not been compiled with UTF-8 support.'
		);
		test(
			@preg_match('/^\pL$/u', 'ñ'),
			'PCRE UTF-8 Unicode',
			'Pass',
			'<a href="http://php.net/pcre">PCRE</a> has not been compiled with Unicode property support.'
		);
		test(
			function_exists('spl_autoload_register'),
			'SPL Enabled',
			'Pass',
			'PHP <a href="http://www.php.net/spl">SPL</a> is either not loaded or not compiled in.'
		);
		test(
			class_exists('ReflectionClass'),
			'Reflection Enabled',
			'Pass',
			'PHP <a href="http://www.php.net/reflection">reflection</a> is either not loaded or not compiled in.'
		);
		test(
			function_exists('filter_list'),
			'Filters Enabled',
			'Pass',
			'The <a href="http://www.php.net/filter">filter</a> extension is either not loaded or not compiled in.'
		);
		test(
			extension_loaded('iconv'),
			'Iconv Extension Loaded',
			'Pass',
			'The <a href="http://php.net/iconv">iconv</a> extension is not loaded.'
		);
		extension_loaded('mbstring') AND 
		test(
			!(ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING),
			'Mbstring Not Overloaded',
			'Pass',
			'The <a href="http://php.net/mbstring">mbstring</a> extension is overloading PHP\'s native string functions.'
		);
		test(
			function_exists('ctype_digit'),
			'Character Type (CTYPE) Extension',
			'Pass',
			'The <a href="http://php.net/ctype">ctype</a> extension is not enabled.'
		);
		test(
			isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO']),
			'URI Determination',
			'Pass',
			'Neither <code>$_SERVER[\'REQUEST_URI\']</code>, <code>$_SERVER[\'PHP_SELF\']</code>, or <code>$_SERVER[\'PATH_INFO\']</code> is available.'
		);
		test(
			extension_loaded('imagick'),
			'Imagick Enabled',
			'Pass',
			'Proxima requires <a href="http://php.net/imagick">imagick</a> for the Image class.'
		);
		test(
			function_exists('mysql_connect'),
			'MySQL Enabled',
			'Pass',
			'Kohana can use the <a href="http://php.net/mysql">MySQL</a> extension to support MySQL databases.'
		);
		test(			
			class_exists('PDO'),
			'PDO Enabled',
			'Pass',
			'Kohana can use <a href="http://php.net/pdo">PDO</a> to support additional databases.'
		);
		test(
			(bool) exec("command -v java >/dev/null && { echo 1; } || { echo 0; }"),
			'JAVA Installed',
			'Pass',
			'Proxima CMS requires JAVA to compile asset files.'
		);
	?>
</table>

<br />

<h1>Optional Tests</h1>

<p>
	The following extensions are not required to run Proxima CMS, but if enabled can provide access to additional classes.
</p>

<table cellspacing="0" class="table">
	<?php
		test(
			extension_loaded('http'),
			'PECL HTTP Enabled',
			'Pass',
			'Kohana can use the <a href="http://php.net/http">http</a> extension for the Request_Client_External class.'
		);
		test(		
			extension_loaded('curl'),
			'cURL Enabled',
			'Pass',
			'Kohana can use the <a href="http://php.net/curl">cURL</a> extension for the Request_Client_External class.'
		);
		test(		
			extension_loaded('mcrypt'),
			'mcrypt Enabled',
			'Pass',
			'Kohana requires <a href="http://php.net/mcrypt">mcrypt</a> for the Encrypt class.'
		);
		test(			
			(bool) exec("command -v git >/dev/null && { echo 1; } || { echo 0; }"),
			'Git Installed',
			'Pass',
			'Proxima can use git to add modules.'
		);			
	?>
</table>