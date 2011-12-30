<?php defined('SYSPATH') or die('No direct script access.');class Migration_Install_20111230151634 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function up(Kohana_Database $db)
	{
		$this->create_users($db);
		$this->create_activities($db);
		$this->create_assets($db);
		$this->create_components($db);
		$this->create_config($db);
		$this->create_mimetypes($db);
		$this->create_migrations($db);
		$this->create_modules($db);
		$this->create_tags($db);
		$this->create_pages($db);
		$this->create_redirects($db);
		$this->create_groups($db);
	}

	private function create_activities($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `activities` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) DEFAULT NULL,
				`type` varchar(31) NOT NULL,
				`text` text NOT NULL,
				`uri` varchar(255) DEFAULT NULL,
				`request_data` text,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				KEY `fk_user_id` (`user_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER activities_date_updated_update BEFORE UPDATE ON activities FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER activities_date_updated_insert BEFORE INSERT ON activities FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
	}

	private function create_assets($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `assets` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL DEFAULT '0',
				`mimetype_id` int(11) NOT NULL DEFAULT '0',
				`folder_id` int(11) NOT NULL DEFAULT '0',
				`title` varchar(255) NOT NULL,
				`description` text NOT NULL,
				`filesize` int(11) NOT NULL,
				`filename` varchar(255) NOT NULL,
				`friendly_filename` varchar(255) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				KEY `fk_user_id` (`user_id`),
				KEY `fk_mimetype_id` (`mimetype_id`),
				FULLTEXT KEY `description` (`description`,`filename`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER assets_date_updated_update BEFORE UPDATE ON assets FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER assets_date_updated_insert BEFORE INSERT ON assets FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `assets_folders` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`parent_id` int(11) NOT NULL DEFAULT '0',
				`name` varchar(255) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER assets_folders_date_updated_update BEFORE UPDATE ON assets_folders FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER assets_folders_date_updated_insert BEFORE INSERT ON assets_folders FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `assets_sizes` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`asset_id` int(11) NOT NULL,
				`width` int(11) NOT NULL,
				`height` int(11) NOT NULL,
				`crop` int(1) NOT NULL,
				`filesize` int(11) NOT NULL,
				`filename` varchar(255) NOT NULL,
				`resized` int(1) NOT NULL DEFAULT '0',
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER assets_sizes_date_updated_update BEFORE UPDATE ON assets_sizes FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER assets_sizes_date_updated_insert BEFORE INSERT ON assets_sizes FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
	}

	private function create_components($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `components` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`type_id` int(11) NOT NULL DEFAULT '0',
				`page_id` int(11) NOT NULL DEFAULT '0',
				`user_id` int(11) NOT NULL,
				`data` text NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER components_date_updated_update BEFORE UPDATE ON components FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER components_date_updated_insert BEFORE INSERT ON components FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `component_types` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL DEFAULT '0',
				`name` varchar(128) NOT NULL,
				`description` varchar(255) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER component_types_date_updated_update BEFORE UPDATE ON component_types FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER component_types_date_updated_insert BEFORE INSERT ON component_types FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
	}

	private function create_config($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `config` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`group_name` varchar(32) NOT NULL,
				`config_key` varchar(32) NOT NULL,
				`label` varchar(64) NOT NULL,
				`config_value` text,
				`default` text,
				`rules` text,
				`field_type` varchar(255) NOT NULL DEFAULT 'text',
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `group` (`group_name`,`config_key`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER config_date_updated_update BEFORE UPDATE ON config FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER config_date_updated_insert BEFORE INSERT ON config FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		// Site - title
		$config = ORM::factory('config');
		$config->values(array(
			'group_name' => 'site',
			'config_key' => 'title',
			'label' => 'Site title',
			'config_value' => serialize('Default title'),
			'default' => serialize('Default title'),
			'rules' => serialize(array(
				array('not_empty'),
				array('max_length', array(':value', 32)),
			))));
		try
		{
			$config->save();
		}
		catch(Database_Exception $e) {}

		// Site - description
		$config = ORM::factory('config');
		$config->values(array(
			'group_name' => 'site',
			'config_key' => 'description',
			'label' => 'Site description',
			'config_value' => serialize('Default description'),
			'default' => serialize('Default description'),
			'rules' => serialize(array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
			))));
		try
		{
			$config->save();
		}
		catch(Database_Exception $e) {}

		// Listing - date format
		$config = ORM::factory('config');
		$config->values(array(
			'group_name' => 'listing',
			'config_key' => 'date_format',
			'label' => 'Date format',
			'config_value' => serialize('jS F Y'),
			'default' => serialize('jS F Y'),
			'rules' => serialize(array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
			))));
		try
		{
			$config->save();
		}
		catch(Database_Exception $e) {}

		// Theming
		$config = ORM::factory('config');
		$config->values(array(
			'group_name' => 'theming',
			'config_key' => 'theme',
			'label' => 'Site theme',
			'config_value' => serialize('1'),
			'default' => serialize('1'),
			'rules' => serialize(array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
			))));
		try
		{
			$config->save();
		}
		catch(Database_Exception $e) {}

		// TinyMCE Plugins
		$config = ORM::factory('config');
		$config->values(array(
			'group_name' => 'tinymce',
			'config_key' => 'plugins',
			'label' => 'TinyMCE Plugins',
			'config_value' => serialize('safari,pagebreak,advimage,advlist,iespell,media,contextmenu,paste,nonbreaking,xhtmlxtras,jqueryinlinepopups,koassets'),
			'default' => serialize('safari,pagebreak,advimage,advlist,iespell,media,contextmenu,paste,nonbreaking,xhtmlxtras,jqueryinlinepopups,koassets'),
			'rules' => serialize(array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
			))));
		try
		{
			$config->save();
		}
		catch(Database_Exception $e) {}

		// TinyMCE Toolbar1
		$config = ORM::factory('config');
		$config->values(array(
			'group_name' => 'tinymce',
			'config_key' => 'toolbar1',
			'label' => 'TinyMCE Toolbar 1',
			'config_value' => serialize('formatselect,|,bold,italic,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,image,koassets,media,|,removeformat,cleanup,code'),
			'default' => serialize('formatselect,|,bold,italic,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,image,koassets,media,|,removeformat,cleanup,code'),
			'rules' => serialize(array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
			))));
		try
		{
			$config->save();
		}
		catch(Database_Exception $e) {}

		// Assets
		$config = ORM::factory('config');
		$config->values(array(
			'group_name' => 'asset',
			'config_key' => 'allowed_upload_type',
			'label' => 'Allowed upload types',
			'config_value' => serialize('jpg,png,gif,pdf,txt,zip,tar'),
			'default' => serialize('jpg,png,gif,pdf,txt,zip,tar'),
			'rules' => serialize(array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
			))));
		try
		{
			$config->save();
		}
		catch(Database_Exception $e) {}
	}

	public function create_groups($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `groups` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`parent_id` int(11) NOT NULL,
				`name` varchar(32) NOT NULL,
				`description` varchar(255) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uniq_name` (`name`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER groups_date_updated_update BEFORE UPDATE ON groups FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER groups_date_updated_insert BEFORE INSERT ON groups FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `groups_users` (
				`user_id` int(10) unsigned NOT NULL,
				`group_id` int(10) unsigned NOT NULL,
				PRIMARY KEY (`user_id`,`group_id`),
				KEY `fk_group_id` (`group_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
		);

		$db->query(NULL, "
			ALTER TABLE `groups_users`
				ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
				ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE"
		);

	}

	public function create_mimetypes($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `mimetypes` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`subtype` varchar(120) NOT NULL,
				`type` varchar(120) NOT NULL,
				`extension` varchar(6) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `type` (`subtype`,`type`,`extension`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER mimetypes_date_updated_update BEFORE UPDATE ON mimetypes FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER mimetypes_date_updated_insert BEFORE INSERT ON mimetypes FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			INSERT INTO `mimetypes` (`id`, `subtype`, `type`, `extension`)
			VALUES
				(1, 'application', 'andrew-inset', 'ez'),
				(2, 'application', 'annodex', 'anx'),
				(3, 'application', 'atom+xml', 'atom'),
				(4, 'application', 'atomcat+xml', 'atomca'),
				(5, 'application', 'atomserv+xml', 'atomsr'),
				(6, 'application', 'bbolin', 'lin'),
				(7, 'application', 'cap', 'cap'),
				(8, 'application', 'cap', 'pcap'),
				(9, 'application', 'cu-seeme', 'cu'),
				(10, 'application', 'davmount+xml', 'davmou'),
				(11, 'application', 'dsptype', 'tsp'),
				(12, 'application', 'ecmascript', 'es'),
				(13, 'application', 'futuresplash', 'spl'),
				(14, 'application', 'hta', 'hta'),
				(15, 'application', 'java-archive', 'jar'),
				(16, 'application', 'java-serialized-object', 'ser'),
				(17, 'application', 'java-vm', 'class'),
				(18, 'application', 'javascript', 'js'),
				(19, 'application', 'm3g', 'm3g'),
				(20, 'application', 'mac-binhex40', 'hqx'),
				(21, 'application', 'mac-compactpro', 'cpt'),
				(22, 'application', 'mathematica', 'nb'),
				(23, 'application', 'mathematica', 'nbp'),
				(24, 'application', 'msaccess', 'mdb'),
				(25, 'application', 'msword', 'doc'),
				(26, 'application', 'msword', 'dot'),
				(27, 'application', 'octet-stream', 'bin'),
				(28, 'application', 'oda', 'oda'),
				(29, 'application', 'ogg', 'ogx'),
				(30, 'application', 'pdf', 'pdf'),
				(31, 'application', 'pgp-keys', 'key'),
				(32, 'application', 'pgp-signature', 'pgp'),
				(33, 'application', 'pics-rules', 'prf'),
				(34, 'application', 'postscript', 'ps'),
				(35, 'application', 'postscript', 'ai'),
				(36, 'application', 'postscript', 'eps'),
				(37, 'application', 'postscript', 'espi'),
				(38, 'application', 'postscript', 'epsf'),
				(39, 'application', 'postscript', 'eps2'),
				(40, 'application', 'postscript', 'eps3'),
				(41, 'application', 'rar', 'rar'),
				(42, 'application', 'rdf+xml', 'rdf'),
				(43, 'application', 'rss+xml', 'rss'),
				(44, 'application', 'rtf', 'rtf'),
				(45, 'application', 'smil', 'smi'),
				(46, 'application', 'smil', 'smil'),
				(47, 'application', 'xhtml+xml', 'xhtml'),
				(48, 'application', 'xhtml+xml', 'xht'),
				(49, 'application', 'xml', 'xml'),
				(50, 'application', 'xml', 'xsl'),
				(51, 'application', 'xml', 'xsd'),
				(52, 'application', 'xspf+xml', 'xspf'),
				(53, 'application', 'zip', 'zip'),
				(54, 'application', 'vnd.cinderella', 'cdy'),
				(55, 'application', 'vnd.google-earth.kml+xml', 'kml'),
				(56, 'application', 'vnd.google-earth.kmz', 'kmz'),
				(57, 'application', 'vnd.mozilla.xul+xml', 'xul'),
				(58, 'application', 'vnd.ms-excel', 'xls'),
				(59, 'application', 'vnd.ms-excel', 'xlb'),
				(60, 'application', 'vnd.ms-excel', 'xlt'),
				(61, 'application', 'vnd.ms-pki.seccat', 'cat'),
				(62, 'application', 'vnd.ms-pki.stl', 'stl'),
				(63, 'application', 'vnd.ms-powerpoint', 'ppt'),
				(64, 'application', 'vnd.ms-powerpoint', 'pps'),
				(65, 'application', 'vnd.oasis.opendocument.chart', 'odc'),
				(66, 'application', 'vnd.oasis.opendocument.database', 'odb'),
				(67, 'application', 'vnd.oasis.opendocument.formula', 'odf'),
				(68, 'application', 'vnd.oasis.opendocument.graphics', 'odg'),
				(69, 'application', 'vnd.oasis.opendocument.graphics-template', 'otg'),
				(70, 'application', 'vnd.oasis.opendocument.image', 'odi'),
				(71, 'application', 'vnd.oasis.opendocument.presentation', 'odp'),
				(72, 'application', 'vnd.oasis.opendocument.presentation-template', 'otp'),
				(73, 'application', 'vnd.oasis.opendocument.spreadsheet', 'ods'),
				(74, 'application', 'vnd.oasis.opendocument.spreadsheet-template', 'ots'),
				(75, 'application', 'vnd.oasis.opendocument.text', 'odt'),
				(76, 'application', 'vnd.oasis.opendocument.text-master', 'odm'),
				(77, 'application', 'vnd.oasis.opendocument.text-template', 'ott'),
				(78, 'application', 'vnd.oasis.opendocument.text-web', 'oth'),
				(79, 'application', 'vnd.rim.cod', 'cod'),
				(80, 'application', 'vnd.smaf', 'mmf'),
				(81, 'application', 'vnd.stardivision.calc', 'sdc'),
				(82, 'application', 'vnd.stardivision.chart', 'sds'),
				(83, 'application', 'vnd.stardivision.draw', 'sda'),
				(84, 'application', 'vnd.stardivision.impress', 'sdd'),
				(85, 'application', 'vnd.stardivision.math', 'sdf'),
				(86, 'application', 'vnd.stardivision.writer', 'sdw'),
				(87, 'application', 'vnd.stardivision.writer-global', 'sgl'),
				(88, 'application', 'vnd.sun.xml.calc', 'sxc'),
				(89, 'application', 'vnd.sun.xml.calc.template', 'stc'),
				(90, 'application', 'vnd.sun.xml.draw', 'sxd'),
				(91, 'application', 'vnd.sun.xml.draw.template', 'std'),
				(92, 'application', 'vnd.sun.xml.impress', 'sxi'),
				(93, 'application', 'vnd.sun.xml.impress.template', 'sti'),
				(94, 'application', 'vnd.sun.xml.math', 'sxm'),
				(95, 'application', 'vnd.sun.xml.writer', 'sxw'),
				(96, 'application', 'vnd.sun.xml.writer.global', 'sxg'),
				(97, 'application', 'vnd.sun.xml.writer.template', 'stw'),
				(98, 'application', 'vnd.symbian.install', 'sis'),
				(99, 'application', 'vnd.visio', 'vsd'),
				(100, 'application', 'vnd.wap.wbxml', 'wbxml'),
				(101, 'application', 'vnd.wap.wmlc', 'wmlc'),
				(102, 'application', 'vnd.wap.wmlscriptc', 'wmlsc'),
				(103, 'application', 'vnd.wordperfect', 'wpd'),
				(104, 'application', 'vnd.wordperfect5.1', 'wp5'),
				(105, 'application', 'x-123', 'wk'),
				(106, 'application', 'x-7z-compressed', '7z'),
				(107, 'application', 'x-abiword', 'abw'),
				(108, 'application', 'x-apple-diskimage', 'dmg'),
				(109, 'application', 'x-bcpio', 'bcpio'),
				(110, 'application', 'x-bittorrent', 'torren'),
				(111, 'application', 'x-cab', 'cab'),
				(112, 'application', 'x-cbr', 'cbr'),
				(113, 'application', 'x-cbz', 'cbz'),
				(114, 'application', 'x-cdf', 'cdf'),
				(115, 'application', 'x-cdf', 'cda'),
				(116, 'application', 'x-cdlink', 'vcd'),
				(117, 'application', 'x-chess-pgn', 'pgn'),
				(118, 'application', 'x-cpio', 'cpio'),
				(119, 'application', 'x-csh', 'csh'),
				(120, 'application', 'x-debian-package', 'deb'),
				(121, 'application', 'x-debian-package', 'udeb'),
				(122, 'application', 'x-director', 'dcr'),
				(123, 'application', 'x-director', 'dir'),
				(124, 'application', 'x-director', 'dxr'),
				(125, 'application', 'x-dms', 'dms'),
				(126, 'application', 'x-doom', 'wad'),
				(127, 'application', 'x-dvi', 'dvi'),
				(128, 'application', 'x-httpd-eruby', 'rhtml'),
				(129, 'application', 'x-font', 'pfa'),
				(130, 'application', 'x-font', 'pfb'),
				(131, 'application', 'x-font', 'gsf'),
				(132, 'application', 'x-font', 'pcf'),
				(133, 'application', 'x-font', 'pcf.Z'),
				(134, 'application', 'x-freemind', 'mm'),
				(135, 'application', 'x-futuresplash', 'spl'),
				(136, 'application', 'x-gnumeric', 'gnumer'),
				(137, 'application', 'x-go-sgf', 'sgf'),
				(138, 'application', 'x-graphing-calculator', 'gcf'),
				(139, 'application', 'x-gtar', 'gtar'),
				(140, 'application', 'x-gtar', 'tgz'),
				(141, 'application', 'x-gtar', 'taz'),
				(142, 'application', 'x-hdf', 'hdf'),
				(143, 'application', 'x-httpd-php', 'phtml'),
				(144, 'application', 'x-httpd-php', 'pht'),
				(145, 'application', 'x-httpd-php', 'php'),
				(146, 'application', 'x-httpd-php-source', 'phps'),
				(147, 'application', 'x-httpd-php3', 'php3'),
				(148, 'application', 'x-httpd-php3-preprocessed', 'php3p'),
				(149, 'application', 'x-httpd-php4', 'php4'),
				(150, 'application', 'x-ica', 'ica'),
				(151, 'application', 'x-info', 'info'),
				(152, 'application', 'x-internet-signup', 'ins'),
				(153, 'application', 'x-internet-signup', 'isp'),
				(154, 'application', 'x-iphone', 'iii'),
				(155, 'application', 'x-iso9660-image', 'iso'),
				(156, 'application', 'x-jam', 'jam'),
				(157, 'application', 'x-java-jnlp-file', 'jnlp'),
				(158, 'application', 'x-jmol', 'jmz'),
				(159, 'application', 'x-kchart', 'chrt'),
				(160, 'application', 'x-killustrator', 'kil'),
				(161, 'application', 'x-koan', 'skp'),
				(162, 'application', 'x-koan', 'skd'),
				(163, 'application', 'x-koan', 'skt'),
				(164, 'application', 'x-koan', 'skm'),
				(165, 'application', 'x-kpresenter', 'kpr'),
				(166, 'application', 'x-kpresenter', 'kpt'),
				(167, 'application', 'x-kspread', 'ksp'),
				(168, 'application', 'x-kword', 'kwd'),
				(169, 'application', 'x-kword', 'kwt'),
				(170, 'application', 'x-latex', 'latex'),
				(171, 'application', 'x-lha', 'lha'),
				(172, 'application', 'x-lyx', 'lyx'),
				(173, 'application', 'x-lzh', 'lzh'),
				(174, 'application', 'x-lzx', 'lzx'),
				(175, 'application', 'x-maker', 'frm'),
				(176, 'application', 'x-maker', 'maker'),
				(177, 'application', 'x-maker', 'frame'),
				(178, 'application', 'x-maker', 'fm'),
				(179, 'application', 'x-maker', 'fb'),
				(180, 'application', 'x-maker', 'book'),
				(181, 'application', 'x-maker', 'fbdoc'),
				(182, 'application', 'x-mif', 'mif'),
				(183, 'application', 'x-ms-wmd', 'wmd'),
				(184, 'application', 'x-ms-wmz', 'wmz'),
				(185, 'application', 'x-msdos-program', 'com'),
				(186, 'application', 'x-msdos-program', 'exe'),
				(187, 'application', 'x-msdos-program', 'bat'),
				(188, 'application', 'x-msdos-program', 'dll'),
				(189, 'application', 'x-msi', 'msi'),
				(190, 'application', 'x-netcdf', 'nc'),
				(191, 'application', 'x-ns-proxy-autoconfig', 'pac'),
				(192, 'application', 'x-ns-proxy-autoconfig', 'dat'),
				(193, 'application', 'x-nwc', 'nwc'),
				(194, 'application', 'x-object', 'o'),
				(195, 'application', 'x-oz-application', 'oza'),
				(196, 'application', 'x-pkcs7-certreqresp', 'p7r'),
				(197, 'application', 'x-pkcs7-crl', 'crl'),
				(198, 'application', 'x-python-code', 'pyc'),
				(199, 'application', 'x-python-code', 'pyo'),
				(200, 'application', 'x-qgis', 'qgs'),
				(201, 'application', 'x-qgis', 'shp'),
				(202, 'application', 'x-qgis', 'shx'),
				(203, 'application', 'x-quicktimeplayer', 'qtl'),
				(204, 'application', 'x-redhat-package-manager', 'rpm'),
				(205, 'application', 'x-ruby', 'rb'),
				(206, 'application', 'x-sh', 'sh'),
				(207, 'application', 'x-shar', 'shar'),
				(208, 'application', 'x-shockwave-flash', 'swf'),
				(209, 'application', 'x-shockwave-flash', 'swfl'),
				(210, 'application', 'x-stuffit', 'sit'),
				(211, 'application', 'x-stuffit', 'sitx'),
				(212, 'application', 'x-sv4cpio', 'sv4cpi'),
				(213, 'application', 'x-sv4crc', 'sv4crc'),
				(214, 'application', 'x-tar', 'tar'),
				(215, 'application', 'x-tcl', 'tcl'),
				(216, 'application', 'x-tex-gf', 'gf'),
				(217, 'application', 'x-tex-pk', 'pk'),
				(218, 'application', 'x-texinfo', 'texinf'),
				(219, 'application', 'x-texinfo', 'texi'),
				(220, 'application', 'x-trash', '~'),
				(221, 'application', 'x-trash', '%'),
				(222, 'application', 'x-trash', 'bak'),
				(223, 'application', 'x-trash', 'old'),
				(224, 'application', 'x-trash', 'sik'),
				(225, 'application', 'x-troff', 't'),
				(226, 'application', 'x-troff', 'tr'),
				(227, 'application', 'x-troff', 'roff'),
				(228, 'application', 'x-troff-man', 'man'),
				(229, 'application', 'x-troff-me', 'me'),
				(230, 'application', 'x-troff-ms', 'ms'),
				(231, 'application', 'x-ustar', 'ustar'),
				(232, 'application', 'x-wais-source', 'src'),
				(233, 'application', 'x-wingz', 'wz'),
				(234, 'application', 'x-x509-ca-cert', 'crt'),
				(235, 'application', 'x-xcf', 'xcf'),
				(236, 'application', 'x-xfig', 'fig'),
				(237, 'application', 'x-xpinstall', 'xpi'),
				(238, 'audio', 'amr', 'amr'),
				(239, 'audio', 'amr-wb', 'awb'),
				(240, 'audio', 'annodex', 'axa'),
				(241, 'audio', 'basic', 'au'),
				(242, 'audio', 'basic', 'snd'),
				(243, 'audio', 'flac', 'flac'),
				(244, 'audio', 'midi', 'mid'),
				(245, 'audio', 'midi', 'midi'),
				(246, 'audio', 'midi', 'kar'),
				(247, 'audio', 'mpeg', 'mpga'),
				(248, 'audio', 'mpeg', 'mpega'),
				(249, 'audio', 'mpeg', 'mp2'),
				(250, 'audio', 'mpeg', 'mp3'),
				(251, 'audio', 'mpeg', 'm4a'),
				(252, 'audio', 'mpegurl', 'm3u'),
				(253, 'audio', 'ogg', 'oga'),
				(254, 'audio', 'ogg', 'ogg'),
				(255, 'audio', 'ogg', 'spx'),
				(256, 'audio', 'prs.sid', 'sid'),
				(257, 'audio', 'x-aiff', 'aif'),
				(258, 'audio', 'x-aiff', 'aiff'),
				(259, 'audio', 'x-aiff', 'aifc'),
				(260, 'audio', 'x-gsm', 'gsm'),
				(261, 'audio', 'x-mpegurl', 'm3u'),
				(262, 'audio', 'x-ms-wma', 'wma'),
				(263, 'audio', 'x-ms-wax', 'wax'),
				(264, 'audio', 'x-pn-realaudio', 'ra'),
				(265, 'audio', 'x-pn-realaudio', 'rm'),
				(266, 'audio', 'x-pn-realaudio', 'ram'),
				(267, 'audio', 'x-realaudio', 'ra'),
				(268, 'audio', 'x-scpls', 'pls'),
				(269, 'audio', 'x-sd2', 'sd2'),
				(270, 'audio', 'x-wav', 'wav'),
				(271, 'chemical', 'x-alchemy', 'alc'),
				(272, 'chemical', 'x-cache', 'cac'),
				(273, 'chemical', 'x-cache', 'cache'),
				(274, 'chemical', 'x-cache-csf', 'csf'),
				(275, 'chemical', 'x-cactvs-binary', 'cbin'),
				(276, 'chemical', 'x-cactvs-binary', 'cascii'),
				(277, 'chemical', 'x-cactvs-binary', 'ctab'),
				(278, 'chemical', 'x-cdx', 'cdx'),
				(279, 'chemical', 'x-cerius', 'cer'),
				(280, 'chemical', 'x-chem3d', 'c3d'),
				(281, 'chemical', 'x-chemdraw', 'chm'),
				(282, 'chemical', 'x-cif', 'cif'),
				(283, 'chemical', 'x-cmdf', 'cmdf'),
				(284, 'chemical', 'x-cml', 'cml'),
				(285, 'chemical', 'x-compass', 'cpa'),
				(286, 'chemical', 'x-crossfire', 'bsd'),
				(287, 'chemical', 'x-csml', 'csml'),
				(288, 'chemical', 'x-csml', 'csm'),
				(289, 'chemical', 'x-ctx', 'ctx'),
				(290, 'chemical', 'x-cxf', 'cxf'),
				(291, 'chemical', 'x-cxf', 'cef'),
				(292, 'chemical', 'x-embl-dl-nucleotide', 'emb'),
				(293, 'chemical', 'x-embl-dl-nucleotide', 'embl'),
				(294, 'chemical', 'x-galactic-spc', 'spc'),
				(295, 'chemical', 'x-gamess-input', 'inp'),
				(296, 'chemical', 'x-gamess-input', 'gam'),
				(297, 'chemical', 'x-gamess-input', 'gamin'),
				(298, 'chemical', 'x-gaussian-checkpoint', 'fch'),
				(299, 'chemical', 'x-gaussian-checkpoint', 'fchk'),
				(300, 'chemical', 'x-gaussian-cube', 'cub'),
				(301, 'chemical', 'x-gaussian-input', 'gau'),
				(302, 'chemical', 'x-gaussian-input', 'gjc'),
				(303, 'chemical', 'x-gaussian-input', 'gjf'),
				(304, 'chemical', 'x-gaussian-log', 'gal'),
				(305, 'chemical', 'x-gcg8-sequence', 'gcg'),
				(306, 'chemical', 'x-genbank', 'gen'),
				(307, 'chemical', 'x-hin', 'hin'),
				(308, 'chemical', 'x-isostar', 'istr'),
				(309, 'chemical', 'x-isostar', 'ist'),
				(310, 'chemical', 'x-jcamp-dx', 'jdx'),
				(311, 'chemical', 'x-jcamp-dx', 'dx'),
				(312, 'chemical', 'x-kinemage', 'kin'),
				(313, 'chemical', 'x-macmolecule', 'mcm'),
				(314, 'chemical', 'x-macromodel-input', 'mmd'),
				(315, 'chemical', 'x-macromodel-input', 'mmod'),
				(316, 'chemical', 'x-mdl-molfile', 'mol'),
				(317, 'chemical', 'x-mdl-rdfile', 'rd'),
				(318, 'chemical', 'x-mdl-rxnfile', 'rxn'),
				(319, 'chemical', 'x-mdl-sdfile', 'sd'),
				(320, 'chemical', 'x-mdl-sdfile', 'sdf'),
				(321, 'chemical', 'x-mdl-tgf', 'tgf'),
				(322, 'chemical', 'x-mmcif', 'mcif'),
				(323, 'chemical', 'x-mol2', 'mol2'),
				(324, 'chemical', 'x-molconn-Z', 'b'),
				(325, 'chemical', 'x-mopac-graph', 'gpt'),
				(326, 'chemical', 'x-mopac-input', 'mop'),
				(327, 'chemical', 'x-mopac-input', 'mopcrt'),
				(328, 'chemical', 'x-mopac-input', 'mpc'),
				(329, 'chemical', 'x-mopac-input', 'zmt'),
				(330, 'chemical', 'x-mopac-out', 'moo'),
				(331, 'chemical', 'x-mopac-vib', 'mvb'),
				(332, 'chemical', 'x-ncbi-asn1', 'asn'),
				(333, 'chemical', 'x-ncbi-asn1-ascii', 'prt'),
				(334, 'chemical', 'x-ncbi-asn1-ascii', 'ent'),
				(335, 'chemical', 'x-ncbi-asn1-binary', 'val'),
				(336, 'chemical', 'x-ncbi-asn1-binary', 'aso'),
				(337, 'chemical', 'x-ncbi-asn1-spec', 'asn'),
				(338, 'chemical', 'x-pdb', 'pdb'),
				(339, 'chemical', 'x-pdb', 'ent'),
				(340, 'chemical', 'x-rosdal', 'ros'),
				(341, 'chemical', 'x-swissprot', 'sw'),
				(342, 'chemical', 'x-vamas-iso14976', 'vms'),
				(343, 'chemical', 'x-vmd', 'vmd'),
				(344, 'chemical', 'x-xtel', 'xtel'),
				(345, 'chemical', 'x-xyz', 'xyz'),
				(346, 'image', 'gif', 'gif'),
				(347, 'image', 'ief', 'ief'),
				(348, 'image', 'jpeg', 'jpeg'),
				(349, 'image', 'jpeg', 'jpg'),
				(350, 'image', 'jpeg', 'jpe'),
				(351, 'image', 'pcx', 'pcx'),
				(352, 'image', 'png', 'png'),
				(353, 'image', 'svg+xml', 'svg'),
				(354, 'image', 'svg+xml', 'svgz'),
				(355, 'image', 'tiff', 'tiff'),
				(356, 'image', 'tiff', 'tif'),
				(357, 'image', 'vnd.djvu', 'djvu'),
				(358, 'image', 'vnd.djvu', 'djv'),
				(359, 'image', 'vnd.wap.wbmp', 'wbmp'),
				(360, 'image', 'x-cmu-raster', 'ras'),
				(361, 'image', 'x-coreldraw', 'cdr'),
				(362, 'image', 'x-coreldrawpattern', 'pat'),
				(363, 'image', 'x-coreldrawtemplate', 'cdt'),
				(364, 'image', 'x-corelphotopaint', 'cpt'),
				(365, 'image', 'x-icon', 'ico'),
				(366, 'image', 'x-jg', 'art'),
				(367, 'image', 'x-jng', 'jng'),
				(368, 'image', 'x-ms-bmp', 'bmp'),
				(369, 'image', 'x-photoshop', 'psd'),
				(370, 'image', 'x-portable-anymap', 'pnm'),
				(371, 'image', 'x-portable-bitmap', 'pbm'),
				(372, 'image', 'x-portable-graymap', 'pgm'),
				(373, 'image', 'x-portable-pixmap', 'ppm'),
				(374, 'image', 'x-rgb', 'rgb'),
				(375, 'image', 'x-xbitmap', 'xbm'),
				(376, 'image', 'x-xpixmap', 'xpm'),
				(377, 'image', 'x-xwindowdump', 'xwd'),
				(378, 'message', 'rfc822', 'eml'),
				(379, 'model', 'iges', 'igs'),
				(380, 'model', 'iges', 'iges'),
				(381, 'model', 'mesh', 'msh'),
				(382, 'model', 'mesh', 'mesh'),
				(383, 'model', 'mesh', 'silo'),
				(384, 'model', 'vrml', 'wrl'),
				(385, 'model', 'vrml', 'vrml'),
				(386, 'text', 'calendar', 'ics'),
				(387, 'text', 'calendar', 'icz'),
				(388, 'text', 'css', 'css'),
				(389, 'text', 'csv', 'csv'),
				(390, 'text', 'h323', '323'),
				(391, 'text', 'html', 'html'),
				(392, 'text', 'html', 'htm'),
				(393, 'text', 'html', 'shtml'),
				(394, 'text', 'iuls', 'uls'),
				(395, 'text', 'mathml', 'mml'),
				(396, 'text', 'plain', 'asc'),
				(397, 'text', 'plain', 'txt'),
				(398, 'text', 'plain', 'text'),
				(399, 'text', 'plain', 'pot'),
				(400, 'text', 'plain', 'brf'),
				(401, 'text', 'richtext', 'rtx'),
				(402, 'text', 'scriptlet', 'sct'),
				(403, 'text', 'scriptlet', 'wsc'),
				(404, 'text', 'texmacs', 'tm'),
				(405, 'text', 'texmacs', 'ts'),
				(406, 'text', 'tab-separated-values', 'tsv'),
				(407, 'text', 'vnd.sun.j2me.app-descriptor', 'jad'),
				(408, 'text', 'vnd.wap.wml', 'wml'),
				(409, 'text', 'vnd.wap.wmlscript', 'wmls'),
				(410, 'text', 'x-bibtex', 'bib'),
				(411, 'text', 'x-boo', 'boo'),
				(412, 'text', 'x-c++hdr', 'h++'),
				(413, 'text', 'x-c++hdr', 'hpp'),
				(414, 'text', 'x-c++hdr', 'hxx'),
				(415, 'text', 'x-c++hdr', 'hh'),
				(416, 'text', 'x-c++src', 'c++'),
				(417, 'text', 'x-c++src', 'cpp'),
				(418, 'text', 'x-c++src', 'cxx'),
				(419, 'text', 'x-c++src', 'cc'),
				(420, 'text', 'x-chdr', 'h'),
				(421, 'text', 'x-component', 'htc'),
				(422, 'text', 'x-csh', 'csh'),
				(423, 'text', 'x-csrc', 'c'),
				(424, 'text', 'x-dsrc', 'd'),
				(425, 'text', 'x-diff', 'diff'),
				(426, 'text', 'x-diff', 'patch'),
				(427, 'text', 'x-haskell', 'hs'),
				(428, 'text', 'x-java', 'java'),
				(429, 'text', 'x-literate-haskell', 'lhs'),
				(430, 'text', 'x-moc', 'moc'),
				(431, 'text', 'x-pascal', 'p'),
				(432, 'text', 'x-pascal', 'pas'),
				(433, 'text', 'x-pcs-gcd', 'gcd'),
				(434, 'text', 'x-perl', 'pl'),
				(435, 'text', 'x-perl', 'pm'),
				(436, 'text', 'x-python', 'py'),
				(437, 'text', 'x-scala', 'scala'),
				(438, 'text', 'x-setext', 'etx'),
				(439, 'text', 'x-sh', 'sh'),
				(440, 'text', 'x-tcl', 'tcl'),
				(441, 'text', 'x-tcl', 'tk'),
				(442, 'text', 'x-tex', 'tex'),
				(443, 'text', 'x-tex', 'ltx'),
				(444, 'text', 'x-tex', 'sty'),
				(445, 'text', 'x-tex', 'cls'),
				(446, 'text', 'x-vcalendar', 'vcs'),
				(447, 'text', 'x-vcard', 'vcf'),
				(448, 'video', '3gpp', '3gp'),
				(449, 'video', 'annodex', 'axv'),
				(450, 'video', 'dl', 'dl'),
				(451, 'video', 'dv', 'dif'),
				(452, 'video', 'dv', 'dv'),
				(453, 'video', 'fli', 'fli'),
				(454, 'video', 'gl', 'gl'),
				(455, 'video', 'mpeg', 'mpeg'),
				(456, 'video', 'mpeg', 'mpg'),
				(457, 'video', 'mpeg', 'mpe'),
				(458, 'video', 'mp4', 'mp4'),
				(459, 'video', 'quicktime', 'qt'),
				(460, 'video', 'quicktime', 'mov'),
				(461, 'video', 'ogg', 'ogv'),
				(462, 'video', 'vnd.mpegurl', 'mxu'),
				(463, 'video', 'x-flv', 'flv'),
				(464, 'video', 'x-la-asf', 'lsf'),
				(465, 'video', 'x-la-asf', 'lsx'),
				(466, 'video', 'x-mng', 'mng'),
				(467, 'video', 'x-ms-asf', 'asf'),
				(468, 'video', 'x-ms-asf', 'asx'),
				(469, 'video', 'x-ms-wm', 'wm'),
				(470, 'video', 'x-ms-wmv', 'wmv'),
				(471, 'video', 'x-ms-wmx', 'wmx'),
				(472, 'video', 'x-ms-wvx', 'wvx'),
				(473, 'video', 'x-msvideo', 'avi'),
				(474, 'video', 'x-sgi-movie', 'movie'),
				(475, 'video', 'x-matroska', 'mpv'),
				(476, 'x-conference', 'x-cooltalk', 'ice'),
				(477, 'x-epoc', 'x-sisx-app', 'sisx'),
				(478, 'x-world', 'x-vrml', 'vrm'),
				(479, 'x-world', 'x-vrml', 'vrml'),
				(480, 'x-world', 'x-vrml', 'wrl');"
		);
	}

	private function create_migrations($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `minion_migrations` (
				`timestamp` varchar(14) NOT NULL,
				`description` varchar(100) NOT NULL,
				`group` varchar(100) NOT NULL,
				`applied` tinyint(1) DEFAULT '0',
				PRIMARY KEY (`timestamp`,`group`),
				UNIQUE KEY `MIGRATION_ID` (`timestamp`,`description`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8"
		);
	}

	private function create_modules($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `modules` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`enabled` tinyint(4) NOT NULL DEFAULT '0',
				`order` int(11) NOT NULL DEFAULT '-1',
				`name` varchar(255) NOT NULL,
				`nav_name` varchar(64) NOT NULL,
				`nav_controller` varchar(64) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER modules_date_updated_update BEFORE UPDATE ON modules FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER modules_date_updated_insert BEFORE INSERT ON modules FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
	}

	private function create_pages($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `pages` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`pagetype_id` int(11) NOT NULL,
				`parent_id` int(11) NOT NULL,
				`is_homepage` tinyint(1) DEFAULT '0',
				`draft` tinyint(1) NOT NULL DEFAULT '1',
				`visible_in_nav` tinyint(1) NOT NULL DEFAULT '1',
				`title` varchar(128) NOT NULL,
				`uri` varchar(255) DEFAULT NULL,
				`description` varchar(255) NOT NULL,
				`body` text NOT NULL,
				`visible_from` timestamp NULL DEFAULT NULL,
				`visible_to` timestamp NULL DEFAULT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uri` (`uri`),
				KEY `fk_user_id` (`user_id`),
				KEY `fk_page_id` (`parent_id`),
				KEY `fk_pagetype_id` (`pagetype_id`),
				FULLTEXT KEY `title` (`title`,`description`,`body`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER pages_date_updated_update BEFORE UPDATE ON pages FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER pages_date_updated_insert BEFORE INSERT ON pages FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `page_types` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`controller` varchar(155) DEFAULT NULL,
				`template` varchar(32) NOT NULL,
				`name` varchar(32) NOT NULL,
				`description` text NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				KEY `controller` (`controller`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER page_types_date_updated_update BEFORE UPDATE ON page_types FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER page_types_date_updated_insert BEFORE INSERT ON page_types FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			INSERT INTO `page_types` (`controller`, `template`, `name`, `description`) VALUES
			(NULL, 'listing.php', 'Listing page', 'A listing template.'),
			(NULL, 'page.php', 'Generic Page', 'Displays a single page'),
			('tag', 'listing_by_tags.php', 'Listing by tags', 'Displays a filtered list by tags'),
			('search', 'search_results.php', 'Search', 'Search results'),
			('contact', 'contact.php', 'Contact page', 'Contact page with contact form');"
		);

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `page_type_component_types` (
				`component_type_id` int(11) NOT NULL DEFAULT '0',
				`page_type_id` int(11) NOT NULL DEFAULT '0',
				`name` varchar(255) NOT NULL,
				KEY `component_type_id` (`component_type_id`,`page_type_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		$db->query(NULL, "
			CREATE VIEW `site_pages` AS
				select
					`page`.`id` AS `id`
					,`page`.`user_id` AS `user_id`
					,`page`.`pagetype_id` AS `pagetype_id`
					,`page`.`parent_id` AS `parent_id`
					,`page`.`is_homepage` AS `is_homepage`
					,`page`.`visible_in_nav` AS `visible_in_nav`
					,`page`.`draft` AS `draft`
					,`page`.`title` AS `title`
					,`page`.`uri` AS `uri`
					,`page`.`description` AS `description`
					,`page`.`body` AS `body`
					,`page`.`visible_from` AS `visible_from`
					,`page`.`visible_to` AS `visible_to`
					,`page`.`date_updated` AS `date_updated`
					,`page`.`date` AS `date`
					,`pagetype`.`controller` AS `pagetype_controller`
					,`pagetype`.`template` AS `pagetype_template`
					,`pagetype`.`name` AS `pagetype_name`
					,`pagetype`.`description` AS `pagetype_description`
					,`user`.`email` AS `user_email`
					,`user`.`username` AS `user_username`,
					group_concat(cast(`tags`.`id` as char charset utf8),'|',cast(`tags`.`user_id` as char charset utf8),'|',`tags`.`name`,'|',`tags`.`slug`,'|',cast(`tags`.`date` as char charset utf8) separator ',') AS `tags`
				from ((((`pages` `page` join `page_types` `pagetype` on((`page`.`pagetype_id` = `pagetype`.`id`)))
				join `users` `user` on((`page`.`user_id` = `user`.`id`)))
				left join `tags_pages` on((`page`.`id` = `tags_pages`.`page_id`)))
				left join `tags` on((`tags_pages`.`tag_id` = `tags`.`id`)))
				where ((`page`.`visible_from` <= now()) and (isnull(`page`.`visible_to`) or (`page`.`visible_to` >= now())) and (`page`.`draft` = 0))
				group by `page`.`id`"
			);

		$db->query(NULL, "
			INSERT INTO `pages`
				(`user_id`, `pagetype_id`, `parent_id`, `is_homepage`, `draft`, `visible_in_nav`, `title`, `uri`, `description`, `body`, `visible_from`, `visible_to`)
			VALUES
				(1, 1, 0, 1, 0, 1, 'Home', '', 'Home page', '<p>Welcome to my website.</p>', CURRENT_TIMESTAMP, NULL)"
		);

	}

	private function create_redirects($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `redirects` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`uri` varchar(255) NOT NULL,
				`target` varchar(255) NOT NULL,
				`target_id` int(11) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uri` (`uri`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER redirects_date_updated_update BEFORE UPDATE ON redirects FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER redirects_date_updated_insert BEFORE INSERT ON redirects FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
	}

	private function create_roles($db)
	{
	}

	private function create_tags($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `tags` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`name` varchar(32) NOT NULL,
				`slug` varchar(128) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER tags_date_updated_update BEFORE UPDATE ON tags FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER tags_date_updated_insert BEFORE INSERT ON tags FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `tags_pages` (
				`page_id` int(10) unsigned NOT NULL,
				`tag_id` int(10) unsigned NOT NULL,
				PRIMARY KEY (`page_id`,`tag_id`),
				KEY `roles_pages_ibfk_2` (`tag_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8"
		);
	}

	private function create_users($db)
	{
		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `roles` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(32) NOT NULL,
				`description` varchar(255) NOT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uniq_name` (`name`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER roles_date_updated_update BEFORE UPDATE ON roles FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER roles_date_updated_insert BEFORE INSERT ON roles FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			INSERT INTO `roles` (`id`, `name`, `description`) VALUES
			(1, 'login', 'Login privileges, granted after account confirmation'),
			(2, 'admin', 'Administrative user, has access to everything.')"
		);

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `roles_users` (
				`user_id` int(10) unsigned NOT NULL,
				`role_id` int(10) unsigned NOT NULL,
				PRIMARY KEY (`user_id`,`role_id`),
				KEY `fk_role_id` (`role_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8"
		);

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `users` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`email` varchar(254) NOT NULL,
				`username` varchar(32) NOT NULL DEFAULT '',
				`password` varchar(64) NOT NULL,
				`logins` int(10) unsigned NOT NULL DEFAULT '0',
				`last_login` int(10) unsigned DEFAULT NULL,
				`date_updated` timestamp NULL DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uniq_username` (`username`),
				UNIQUE KEY `uniq_email` (`email`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "CREATE TRIGGER users_date_updated_update BEFORE UPDATE ON users FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");
		$db->query(NULL, "CREATE TRIGGER users_date_updated_insert BEFORE INSERT ON users FOR EACH ROW SET NEW.date_updated = CURRENT_TIMESTAMP");

		$db->query(NULL, "
			INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`)
			VALUES (1, 'admin@example.com', 'admin', 'b9314be4ac625671d4048b5e6a5e8c178c9c0c910e7ef2a629a6b2afc40804c5', 0, 0)"
		);
		$db->query(NULL, "INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES (1, 1)"); // login role
		$db->query(NULL, "INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES (1, 2)"); // admin role

		$db->query(NULL, "
			CREATE TABLE IF NOT EXISTS `user_tokens` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`user_id` int(11) unsigned NOT NULL,
				`user_agent` varchar(40) NOT NULL,
				`token` varchar(40) NOT NULL,
				`type` varchar(100) NOT NULL,
				`created` int(10) unsigned NOT NULL,
				`expires` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uniq_token` (`token`),
				KEY `fk_user_id` (`user_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
		);

		$db->query(NULL, "
			ALTER TABLE `roles_users`
				ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
				ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE"
		);

		$db->query(NULL, "ALTER TABLE `user_tokens` ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE");
	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function down(Kohana_Database $db)
	{
		$db->query(NULL, 'DROP TRIGGER IF EXISTS activities_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS activities_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS assets_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS assets_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS assets_folders_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS assets_folders_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS assets_sizes_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS assets_sizes_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS components_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS components_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS component_types_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS component_types_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS config_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS config_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS groups_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS groups_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS mimetypes_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS mimetypes_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS modules_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS modules_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS pages_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS pages_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS page_types_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS page_types_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS redirects_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS redirects_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS roles_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS roles_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS tags_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS tags_date_updated_insert');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS users_date_updated_update');
		$db->query(NULL, 'DROP TRIGGER IF EXISTS users_date_updated_insert');

		try
		{
			$db->query(NULL, "
				ALTER TABLE `groups_users`
					DROP FOREIGN KEY `groups_users_ibfk_1`,
					DROP FOREIGN KEY `groups_users_ibfk_2`"
			);
		}
		catch(Database_Exception $e) {}
		try
		{
			$db->query(NULL, "
				ALTER TABLE `roles_users`
					DROP FOREIGN KEY `roles_users_ibfk_1`,
					DROP FOREIGN KEY `roles_users_ibfk_2`"
			);
		}
		catch(Database_Exception $e) {}
		try
		{
			$db->query(NULL, "
				ALTER TABLE `user_tokens`
					DROP FOREIGN KEY `user_tokens_ibfk_1``"
			);
		}
		catch(Database_Exception $e) {}

		$db->query(NULL, 'DROP TABLE IF EXISTS activities');
		$db->query(NULL, 'DROP TABLE IF EXISTS assets');
		$db->query(NULL, 'DROP TABLE IF EXISTS assets_folders');
		$db->query(NULL, 'DROP TABLE IF EXISTS assets_sizes');
		$db->query(NULL, 'DROP TABLE IF EXISTS components');
		$db->query(NULL, 'DROP TABLE IF EXISTS component_types');
		$db->query(NULL, 'DROP TABLE IF EXISTS config');
		$db->query(NULL, 'DROP TABLE IF EXISTS groups_users');
		$db->query(NULL, 'DROP TABLE IF EXISTS groups');
		$db->query(NULL, 'DROP TABLE IF EXISTS mimetypes');
		$db->query(NULL, 'DROP TABLE IF EXISTS modules');
		$db->query(NULL, 'DROP TABLE IF EXISTS pages');
		$db->query(NULL, 'DROP TABLE IF EXISTS page_types');
		$db->query(NULL, 'DROP TABLE IF EXISTS page_type_component_types');
		$db->query(NULL, 'DROP TABLE IF EXISTS redirects');
		$db->query(NULL, 'DROP TABLE IF EXISTS roles');
		$db->query(NULL, 'DROP TABLE IF EXISTS roles_users');
		$db->query(NULL, 'DROP VIEW IF EXISTS site_pages');
		$db->query(NULL, 'DROP TABLE IF EXISTS tags');
		$db->query(NULL, 'DROP TABLE IF EXISTS tags_pages');
		$db->query(NULL, 'DROP TABLE IF EXISTS user_tokens');
		$db->query(NULL, 'DROP TABLE IF EXISTS users');
	}
	}
