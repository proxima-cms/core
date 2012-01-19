	<?php $failed = FALSE ?>

	<table cellspacing="0">
		<tr>
			<th>PHP Version</th>
			<?php if (version_compare(PHP_VERSION, '5.2.3', '>=')): ?>
				<td class="pass"><?php echo PHP_VERSION ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">Kohana requires PHP 5.2.3 or newer, this version is <?php echo PHP_VERSION ?>.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>System Directory</th>
			<?php if (is_dir(SYSPATH) AND is_file(SYSPATH.'classes/kohana'.EXT)): ?>
				<td class="pass"><?php echo SYSPATH ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The configured <code>system</code> directory does not exist or does not contain required files.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Application Directory</th>
			<?php if (is_dir(APPPATH) AND is_file(APPPATH.'bootstrap'.EXT)): ?>
				<td class="pass"><?php echo APPPATH ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The configured <code>application</code> directory does not exist or does not contain required files.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Cache Directory</th>
			<?php if (is_dir(APPPATH) AND is_dir(APPPATH.'cache') AND is_writable(APPPATH.'cache')): ?>
				<td class="pass"><?php echo APPPATH.'cache/' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo APPPATH.'cache/' ?></code> directory is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Logs Directory</th>
			<?php if (is_dir(APPPATH) AND is_dir(APPPATH.'logs') AND is_writable(APPPATH.'logs')): ?>
				<td class="pass"><?php echo APPPATH.'logs/' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo APPPATH.'logs/' ?></code> directory is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Media Directory</th>
			<?php if (is_dir(DOCROOT.'media') AND is_writable(DOCROOT.'media')): ?>
				<td class="pass"><?php echo DOCROOT.'media/' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo DOCROOT.'media/' ?></code> directory is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Assets Directory</th>
			<?php if (is_dir(DOCROOT.'/media/assets') AND is_writable(DOCROOT.'media/assets')): ?>
				<td class="pass"><?php echo DOCROOT.'media/assets' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo DOCROOT.'media/assets' ?></code> directory is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Assets Resized Directory</th>
			<?php if (is_dir(DOCROOT.'/media/assets/resized') AND is_writable(DOCROOT.'media/assets/resized')): ?>
				<td class="pass"><?php echo DOCROOT.'media/assets/resized' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo DOCROOT.'media/assets/resized' ?></code> directory is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Media Cache Directory</th>
			<?php if (is_dir(DOCROOT.'/media/cache') AND is_writable(DOCROOT.'media/cache')): ?>
				<td class="pass"><?php echo DOCROOT.'media/cache' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo DOCROOT.'media/cache' ?></code> directory is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Modules config file</th>
			<?php if (is_dir(APPPATH.'config') AND is_file(APPPATH.'config/modules.php') AND is_writable(APPPATH.'config/modules.php')): ?>
				<td class="pass"><?php echo APPPATH.'config/modules' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo APPPATH.'config/modules.php' ?></code> file is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Admin nav config file</th>
			<?php if (is_dir(CORPATH.'config') AND is_dir(CORPATH.'config/admin') AND is_file(CORPATH.'config/admin/nav.php') AND is_writable(CORPATH.'config/admin/nav.php')): ?>
				<td class="pass"><?php echo CORPATH.'config/admin/nav.php' ?></td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <code><?php echo CORPATH.'config/admin/nav.php' ?></code> file is not writable.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>PCRE UTF-8</th>
			<?php if ( ! @preg_match('/^.$/u', 'ñ')): $failed = TRUE ?>
				<td class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with UTF-8 support.</td>
			<?php elseif ( ! @preg_match('/^\pL$/u', 'ñ')): $failed = TRUE ?>
				<td class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with Unicode property support.</td>
			<?php else: ?>
				<td class="pass">Pass</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>SPL Enabled</th>
			<?php if (function_exists('spl_autoload_register')): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">PHP <a href="http://www.php.net/spl">SPL</a> is either not loaded or not compiled in.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Reflection Enabled</th>
			<?php if (class_exists('ReflectionClass')): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">PHP <a href="http://www.php.net/reflection">reflection</a> is either not loaded or not compiled in.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Filters Enabled</th>
			<?php if (function_exists('filter_list')): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <a href="http://www.php.net/filter">filter</a> extension is either not loaded or not compiled in.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Iconv Extension Loaded</th>
			<?php if (extension_loaded('iconv')): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">The <a href="http://php.net/iconv">iconv</a> extension is not loaded.</td>
			<?php endif ?>
		</tr>
		<?php if (extension_loaded('mbstring')): ?>
		<tr>
			<th>Mbstring Not Overloaded</th>
			<?php if (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING): $failed = TRUE ?>
				<td class="fail">The <a href="http://php.net/mbstring">mbstring</a> extension is overloading PHP's native string functions.</td>
			<?php else: ?>
				<td class="pass">Pass</td>
			<?php endif ?>
		</tr>
		<?php endif ?>
		<tr>
			<th>Character Type (CTYPE) Extension</th>
			<?php if ( ! function_exists('ctype_digit')): $failed = TRUE ?>
				<td class="fail">The <a href="http://php.net/ctype">ctype</a> extension is not enabled.</td>
			<?php else: ?>
				<td class="pass">Pass</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>URI Determination</th>
			<?php if (isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO'])): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">Neither <code>$_SERVER['REQUEST_URI']</code>, <code>$_SERVER['PHP_SELF']</code>, or <code>$_SERVER['PATH_INFO']</code> is available.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Imagick Enabled</th>
			<?php if (extension_loaded('imagick')): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">Proxima requires <a href="http://php.net/imagick">imagick</a> for the Image class.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>MySQL Enabled</th>
			<?php if (function_exists('mysql_connect')): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">Kohana can use the <a href="http://php.net/mysql">MySQL</a> extension to support MySQL databases.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>PDO Enabled</th>
			<?php if (class_exists('PDO')): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">Kohana can use <a href="http://php.net/pdo">PDO</a> to support additional databases.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>JAVA Installed</th>
			<?php if ((bool) exec("command -v java >/dev/null && { echo 1; } || { echo 0; }")): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">Proxima CMS requires JAVA to compile asset files.</td>
			<?php endif ?>
		</tr>
	</table>

	<br />

	<h1>Optional Tests</h1>

	<p>
		The following extensions are not required to run Proxima CMS, but if enabled can provide access to additional classes.
	</p>

	<table cellspacing="0">
		<tr>
			<th>PECL HTTP Enabled</th>
			<?php if (extension_loaded('http')): ?>
				<td class="pass">Pass</td>
			<?php else: ?>
				<td class="fail">Kohana can use the <a href="http://php.net/http">http</a> extension for the Request_Client_External class.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>cURL Enabled</th>
			<?php if (extension_loaded('curl')): ?>
				<td class="pass">Pass</td>
			<?php else: ?>
				<td class="fail">Kohana can use the <a href="http://php.net/curl">cURL</a> extension for the Request_Client_External class.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>mcrypt Enabled</th>
			<?php if (extension_loaded('mcrypt')): ?>
				<td class="pass">Pass</td>
			<?php else: ?>
				<td class="fail">Kohana requires <a href="http://php.net/mcrypt">mcrypt</a> for the Encrypt class.</td>
			<?php endif ?>
		</tr>
		<tr>
			<th>Git Installed</th>
			<?php if ((bool) exec("command -v git >/dev/null && { echo 1; } || { echo 0; }")): ?>
				<td class="pass">Pass</td>
			<?php else: $failed = TRUE ?>
				<td class="fail">Proxima can use git to add modules.</td>
			<?php endif ?>
		</tr>
	</table>

	<br />

	<?php if ($failed === TRUE): ?>
		<p id="results" class="fail"><?php echo $fail_msg; ?></p>
	<?php else: ?>
		<p id="results" class="pass"><?php echo $pass_msg; ?>
		</p>
	<?php endif ?>