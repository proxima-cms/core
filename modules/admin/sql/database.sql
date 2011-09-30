-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 30, 2011 at 12:52 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `blog.badsyntax.co_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(31) NOT NULL,
  `text` text NOT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `request_data` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `activities`
--


-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mimetype_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `filesize` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `friendly_filename` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_mimetype_id` (`mimetype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `user_id`, `mimetype_id`, `title`, `description`, `filesize`, `filename`, `friendly_filename`, `date`) VALUES
(1, 0, 0, '', 'arbeit logo', 13126, '1_arbeit-logo.jpeg', '', '2011-09-30 01:42:10'),
(2, 0, 0, '', 'proxim centauri', 43208, '2_proxim-centauri.jpg', 'proxim-centauri.jpg', '2011-09-30 01:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `assets_sizes`
--

CREATE TABLE IF NOT EXISTS `assets_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `crop` int(1) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `resized` int(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `assets_sizes`
--


-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL,
  `config_key` varchar(32) NOT NULL,
  `label` varchar(64) NOT NULL,
  `config_value` text,
  `default` text,
  `rules` text,
  `field_type` varchar(255) NOT NULL DEFAULT 'text',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group_name`,`config_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `group_name`, `config_key`, `label`, `config_value`, `default`, `rules`, `field_type`, `date`) VALUES
(8, 'site', 'title', 'Site title', 's:15:"Default titlede";', 's:13:"Default title";', 'a:2:{i:0;a:1:{i:0;s:9:"not_empty";}i:1;a:2:{i:0;s:10:"max_length";i:1;a:2:{i:0;s:6:":value";i:1;i:32;}}}', 'text', '2011-09-29 19:55:27'),
(9, 'site', 'description', 'Site description', 's:23:"Default descriptionssds";', 's:19:"Default description";', 'a:2:{i:0;a:1:{i:0;s:9:"not_empty";}i:1;a:2:{i:0;s:10:"max_length";i:1;a:2:{i:0;s:6:":value";i:1;i:255;}}}', 'text', '2011-09-29 19:55:27'),
(10, 'theming', 'theme', 'Site theme', 's:1:"1";', 's:1:"1";', 'a:2:{i:0;a:1:{i:0;s:9:"not_empty";}i:1;a:2:{i:0;s:10:"max_length";i:1;a:2:{i:0;s:6:":value";i:1;i:255;}}}', 'text', '2011-09-29 19:55:27'),
(11, 'tinymce', 'plugins', 'TinyMCE Plugins', 's:116:"safari,pagebreak,advimage,advlist,iespell,media,contextmenu,paste,nonbreaking,xhtmlxtras,jqueryinlinepopups,koassets";', 's:116:"safari,pagebreak,advimage,advlist,iespell,media,contextmenu,paste,nonbreaking,xhtmlxtras,jqueryinlinepopups,koassets";', 'a:2:{i:0;a:1:{i:0;s:9:"not_empty";}i:1;a:2:{i:0;s:10:"max_length";i:1;a:2:{i:0;s:6:":value";i:1;i:255;}}}', 'text', '2011-09-29 19:55:28'),
(12, 'tinymce', 'toolbar1', 'TinyMCE Toolbar 1', 's:164:"formatselect,|,bold,italic,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,image,koassets,media,|,removeformat,cleanup,code";', 's:164:"formatselect,|,bold,italic,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,image,koassets,media,|,removeformat,cleanup,code";', 'a:2:{i:0;a:1:{i:0;s:9:"not_empty";}i:1;a:2:{i:0;s:10:"max_length";i:1;a:2:{i:0;s:6:":value";i:1;i:255;}}}', 'text', '2011-09-29 19:55:28'),
(13, 'asset', 'allowed_upload_type', 'Allowed upload types', 's:27:"jpg,png,gif,pdf,txt,zip,tar";', 's:27:"jpg,png,gif,pdf,txt,zip,tar";', 'a:2:{i:0;a:1:{i:0;s:9:"not_empty";}i:1;a:2:{i:0;s:10:"max_length";i:1;a:2:{i:0;s:6:":value";i:1;i:255;}}}', 'text', '2011-09-29 19:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `fk_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `mimetypes`
--

CREATE TABLE IF NOT EXISTS `mimetypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subtype` varchar(120) NOT NULL,
  `type` varchar(120) NOT NULL,
  `extension` varchar(6) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`subtype`,`type`,`extension`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=482 ;

--
-- Dumping data for table `mimetypes`
--

INSERT INTO `mimetypes` (`id`, `subtype`, `type`, `extension`, `date`) VALUES
(1, 'application', 'andrew-inset', 'ez', '2011-09-24 15:48:30'),
(2, 'application', 'annodex', 'anx', '2011-09-24 15:48:30'),
(3, 'application', 'atom+xml', 'atom', '2011-09-24 15:48:30'),
(4, 'application', 'atomcat+xml', 'atomca', '2011-09-24 15:48:30'),
(5, 'application', 'atomserv+xml', 'atomsr', '2011-09-24 15:48:30'),
(6, 'application', 'bbolin', 'lin', '2011-09-24 15:48:30'),
(7, 'application', 'cap', 'cap', '2011-09-24 15:48:30'),
(8, 'application', 'cap', 'pcap', '2011-09-24 15:48:30'),
(9, 'application', 'cu-seeme', 'cu', '2011-09-24 15:48:30'),
(10, 'application', 'davmount+xml', 'davmou', '2011-09-24 15:48:30'),
(11, 'application', 'dsptype', 'tsp', '2011-09-24 15:48:30'),
(12, 'application', 'ecmascript', 'es', '2011-09-24 15:48:30'),
(13, 'application', 'futuresplash', 'spl', '2011-09-24 15:48:30'),
(14, 'application', 'hta', 'hta', '2011-09-24 15:48:30'),
(15, 'application', 'java-archive', 'jar', '2011-09-24 15:48:30'),
(16, 'application', 'java-serialized-object', 'ser', '2011-09-24 15:48:30'),
(17, 'application', 'java-vm', 'class', '2011-09-24 15:48:30'),
(18, 'application', 'javascript', 'js', '2011-09-24 15:48:30'),
(19, 'application', 'm3g', 'm3g', '2011-09-24 15:48:30'),
(20, 'application', 'mac-binhex40', 'hqx', '2011-09-24 15:48:30'),
(21, 'application', 'mac-compactpro', 'cpt', '2011-09-24 15:48:30'),
(22, 'application', 'mathematica', 'nb', '2011-09-24 15:48:30'),
(23, 'application', 'mathematica', 'nbp', '2011-09-24 15:48:30'),
(24, 'application', 'msaccess', 'mdb', '2011-09-24 15:48:30'),
(25, 'application', 'msword', 'doc', '2011-09-24 15:48:30'),
(26, 'application', 'msword', 'dot', '2011-09-24 15:48:30'),
(27, 'application', 'octet-stream', 'bin', '2011-09-24 15:48:30'),
(28, 'application', 'oda', 'oda', '2011-09-24 15:48:30'),
(29, 'application', 'ogg', 'ogx', '2011-09-24 15:48:30'),
(30, 'application', 'pdf', 'pdf', '2011-09-24 15:48:30'),
(31, 'application', 'pgp-keys', 'key', '2011-09-24 15:48:30'),
(32, 'application', 'pgp-signature', 'pgp', '2011-09-24 15:48:30'),
(33, 'application', 'pics-rules', 'prf', '2011-09-24 15:48:30'),
(34, 'application', 'postscript', 'ps', '2011-09-24 15:48:30'),
(35, 'application', 'postscript', 'ai', '2011-09-24 15:48:30'),
(36, 'application', 'postscript', 'eps', '2011-09-24 15:48:30'),
(37, 'application', 'postscript', 'espi', '2011-09-24 15:48:30'),
(38, 'application', 'postscript', 'epsf', '2011-09-24 15:48:30'),
(39, 'application', 'postscript', 'eps2', '2011-09-24 15:48:30'),
(40, 'application', 'postscript', 'eps3', '2011-09-24 15:48:30'),
(41, 'application', 'rar', 'rar', '2011-09-24 15:48:30'),
(42, 'application', 'rdf+xml', 'rdf', '2011-09-24 15:48:30'),
(43, 'application', 'rss+xml', 'rss', '2011-09-24 15:48:30'),
(44, 'application', 'rtf', 'rtf', '2011-09-24 15:48:30'),
(45, 'application', 'smil', 'smi', '2011-09-24 15:48:30'),
(46, 'application', 'smil', 'smil', '2011-09-24 15:48:30'),
(47, 'application', 'xhtml+xml', 'xhtml', '2011-09-24 15:48:30'),
(48, 'application', 'xhtml+xml', 'xht', '2011-09-24 15:48:30'),
(49, 'application', 'xml', 'xml', '2011-09-24 15:48:30'),
(50, 'application', 'xml', 'xsl', '2011-09-24 15:48:30'),
(51, 'application', 'xml', 'xsd', '2011-09-24 15:48:30'),
(52, 'application', 'xspf+xml', 'xspf', '2011-09-24 15:48:30'),
(53, 'application', 'zip', 'zip', '2011-09-24 15:48:30'),
(54, 'application', 'vnd.cinderella', 'cdy', '2011-09-24 15:48:30'),
(55, 'application', 'vnd.google-earth.kml+xml', 'kml', '2011-09-24 15:48:30'),
(56, 'application', 'vnd.google-earth.kmz', 'kmz', '2011-09-24 15:48:30'),
(57, 'application', 'vnd.mozilla.xul+xml', 'xul', '2011-09-24 15:48:30'),
(58, 'application', 'vnd.ms-excel', 'xls', '2011-09-24 15:48:30'),
(59, 'application', 'vnd.ms-excel', 'xlb', '2011-09-24 15:48:30'),
(60, 'application', 'vnd.ms-excel', 'xlt', '2011-09-24 15:48:30'),
(61, 'application', 'vnd.ms-pki.seccat', 'cat', '2011-09-24 15:48:30'),
(62, 'application', 'vnd.ms-pki.stl', 'stl', '2011-09-24 15:48:30'),
(63, 'application', 'vnd.ms-powerpoint', 'ppt', '2011-09-24 15:48:30'),
(64, 'application', 'vnd.ms-powerpoint', 'pps', '2011-09-24 15:48:30'),
(65, 'application', 'vnd.oasis.opendocument.chart', 'odc', '2011-09-24 15:48:30'),
(66, 'application', 'vnd.oasis.opendocument.database', 'odb', '2011-09-24 15:48:30'),
(67, 'application', 'vnd.oasis.opendocument.formula', 'odf', '2011-09-24 15:48:30'),
(68, 'application', 'vnd.oasis.opendocument.graphics', 'odg', '2011-09-24 15:48:30'),
(69, 'application', 'vnd.oasis.opendocument.graphics-template', 'otg', '2011-09-24 15:48:30'),
(70, 'application', 'vnd.oasis.opendocument.image', 'odi', '2011-09-24 15:48:30'),
(71, 'application', 'vnd.oasis.opendocument.presentation', 'odp', '2011-09-24 15:48:30'),
(72, 'application', 'vnd.oasis.opendocument.presentation-template', 'otp', '2011-09-24 15:48:30'),
(73, 'application', 'vnd.oasis.opendocument.spreadsheet', 'ods', '2011-09-24 15:48:30'),
(74, 'application', 'vnd.oasis.opendocument.spreadsheet-template', 'ots', '2011-09-24 15:48:30'),
(75, 'application', 'vnd.oasis.opendocument.text', 'odt', '2011-09-24 15:48:30'),
(76, 'application', 'vnd.oasis.opendocument.text-master', 'odm', '2011-09-24 15:48:30'),
(77, 'application', 'vnd.oasis.opendocument.text-template', 'ott', '2011-09-24 15:48:30'),
(78, 'application', 'vnd.oasis.opendocument.text-web', 'oth', '2011-09-24 15:48:30'),
(79, 'application', 'vnd.rim.cod', 'cod', '2011-09-24 15:48:30'),
(80, 'application', 'vnd.smaf', 'mmf', '2011-09-24 15:48:30'),
(81, 'application', 'vnd.stardivision.calc', 'sdc', '2011-09-24 15:48:30'),
(82, 'application', 'vnd.stardivision.chart', 'sds', '2011-09-24 15:48:30'),
(83, 'application', 'vnd.stardivision.draw', 'sda', '2011-09-24 15:48:30'),
(84, 'application', 'vnd.stardivision.impress', 'sdd', '2011-09-24 15:48:30'),
(85, 'application', 'vnd.stardivision.math', 'sdf', '2011-09-24 15:48:30'),
(86, 'application', 'vnd.stardivision.writer', 'sdw', '2011-09-24 15:48:30'),
(87, 'application', 'vnd.stardivision.writer-global', 'sgl', '2011-09-24 15:48:30'),
(88, 'application', 'vnd.sun.xml.calc', 'sxc', '2011-09-24 15:48:30'),
(89, 'application', 'vnd.sun.xml.calc.template', 'stc', '2011-09-24 15:48:30'),
(90, 'application', 'vnd.sun.xml.draw', 'sxd', '2011-09-24 15:48:30'),
(91, 'application', 'vnd.sun.xml.draw.template', 'std', '2011-09-24 15:48:30'),
(92, 'application', 'vnd.sun.xml.impress', 'sxi', '2011-09-24 15:48:30'),
(93, 'application', 'vnd.sun.xml.impress.template', 'sti', '2011-09-24 15:48:30'),
(94, 'application', 'vnd.sun.xml.math', 'sxm', '2011-09-24 15:48:30'),
(95, 'application', 'vnd.sun.xml.writer', 'sxw', '2011-09-24 15:48:30'),
(96, 'application', 'vnd.sun.xml.writer.global', 'sxg', '2011-09-24 15:48:30'),
(97, 'application', 'vnd.sun.xml.writer.template', 'stw', '2011-09-24 15:48:30'),
(98, 'application', 'vnd.symbian.install', 'sis', '2011-09-24 15:48:30'),
(99, 'application', 'vnd.visio', 'vsd', '2011-09-24 15:48:30'),
(100, 'application', 'vnd.wap.wbxml', 'wbxml', '2011-09-24 15:48:30'),
(101, 'application', 'vnd.wap.wmlc', 'wmlc', '2011-09-24 15:48:30'),
(102, 'application', 'vnd.wap.wmlscriptc', 'wmlsc', '2011-09-24 15:48:30'),
(103, 'application', 'vnd.wordperfect', 'wpd', '2011-09-24 15:48:30'),
(104, 'application', 'vnd.wordperfect5.1', 'wp5', '2011-09-24 15:48:30'),
(105, 'application', 'x-123', 'wk', '2011-09-24 15:48:30'),
(106, 'application', 'x-7z-compressed', '7z', '2011-09-24 15:48:30'),
(107, 'application', 'x-abiword', 'abw', '2011-09-24 15:48:30'),
(108, 'application', 'x-apple-diskimage', 'dmg', '2011-09-24 15:48:30'),
(109, 'application', 'x-bcpio', 'bcpio', '2011-09-24 15:48:30'),
(110, 'application', 'x-bittorrent', 'torren', '2011-09-24 15:48:30'),
(111, 'application', 'x-cab', 'cab', '2011-09-24 15:48:30'),
(112, 'application', 'x-cbr', 'cbr', '2011-09-24 15:48:30'),
(113, 'application', 'x-cbz', 'cbz', '2011-09-24 15:48:30'),
(114, 'application', 'x-cdf', 'cdf', '2011-09-24 15:48:30'),
(115, 'application', 'x-cdf', 'cda', '2011-09-24 15:48:30'),
(116, 'application', 'x-cdlink', 'vcd', '2011-09-24 15:48:30'),
(117, 'application', 'x-chess-pgn', 'pgn', '2011-09-24 15:48:30'),
(118, 'application', 'x-cpio', 'cpio', '2011-09-24 15:48:30'),
(119, 'application', 'x-csh', 'csh', '2011-09-24 15:48:30'),
(120, 'application', 'x-debian-package', 'deb', '2011-09-24 15:48:30'),
(121, 'application', 'x-debian-package', 'udeb', '2011-09-24 15:48:30'),
(122, 'application', 'x-director', 'dcr', '2011-09-24 15:48:30'),
(123, 'application', 'x-director', 'dir', '2011-09-24 15:48:30'),
(124, 'application', 'x-director', 'dxr', '2011-09-24 15:48:30'),
(125, 'application', 'x-dms', 'dms', '2011-09-24 15:48:30'),
(126, 'application', 'x-doom', 'wad', '2011-09-24 15:48:30'),
(127, 'application', 'x-dvi', 'dvi', '2011-09-24 15:48:30'),
(128, 'application', 'x-httpd-eruby', 'rhtml', '2011-09-24 15:48:30'),
(129, 'application', 'x-font', 'pfa', '2011-09-24 15:48:30'),
(130, 'application', 'x-font', 'pfb', '2011-09-24 15:48:30'),
(131, 'application', 'x-font', 'gsf', '2011-09-24 15:48:30'),
(132, 'application', 'x-font', 'pcf', '2011-09-24 15:48:30'),
(133, 'application', 'x-font', 'pcf.Z', '2011-09-24 15:48:30'),
(134, 'application', 'x-freemind', 'mm', '2011-09-24 15:48:30'),
(135, 'application', 'x-futuresplash', 'spl', '2011-09-24 15:48:30'),
(136, 'application', 'x-gnumeric', 'gnumer', '2011-09-24 15:48:30'),
(137, 'application', 'x-go-sgf', 'sgf', '2011-09-24 15:48:30'),
(138, 'application', 'x-graphing-calculator', 'gcf', '2011-09-24 15:48:30'),
(139, 'application', 'x-gtar', 'gtar', '2011-09-24 15:48:30'),
(140, 'application', 'x-gtar', 'tgz', '2011-09-24 15:48:30'),
(141, 'application', 'x-gtar', 'taz', '2011-09-24 15:48:30'),
(142, 'application', 'x-hdf', 'hdf', '2011-09-24 15:48:30'),
(143, 'application', 'x-httpd-php', 'phtml', '2011-09-24 15:48:30'),
(144, 'application', 'x-httpd-php', 'pht', '2011-09-24 15:48:30'),
(145, 'application', 'x-httpd-php', 'php', '2011-09-24 15:48:30'),
(146, 'application', 'x-httpd-php-source', 'phps', '2011-09-24 15:48:30'),
(147, 'application', 'x-httpd-php3', 'php3', '2011-09-24 15:48:30'),
(148, 'application', 'x-httpd-php3-preprocessed', 'php3p', '2011-09-24 15:48:30'),
(149, 'application', 'x-httpd-php4', 'php4', '2011-09-24 15:48:30'),
(150, 'application', 'x-ica', 'ica', '2011-09-24 15:48:30'),
(151, 'application', 'x-info', 'info', '2011-09-24 15:48:30'),
(152, 'application', 'x-internet-signup', 'ins', '2011-09-24 15:48:30'),
(153, 'application', 'x-internet-signup', 'isp', '2011-09-24 15:48:30'),
(154, 'application', 'x-iphone', 'iii', '2011-09-24 15:48:30'),
(155, 'application', 'x-iso9660-image', 'iso', '2011-09-24 15:48:30'),
(156, 'application', 'x-jam', 'jam', '2011-09-24 15:48:30'),
(157, 'application', 'x-java-jnlp-file', 'jnlp', '2011-09-24 15:48:30'),
(158, 'application', 'x-jmol', 'jmz', '2011-09-24 15:48:30'),
(159, 'application', 'x-kchart', 'chrt', '2011-09-24 15:48:30'),
(160, 'application', 'x-killustrator', 'kil', '2011-09-24 15:48:30'),
(161, 'application', 'x-koan', 'skp', '2011-09-24 15:48:30'),
(162, 'application', 'x-koan', 'skd', '2011-09-24 15:48:30'),
(163, 'application', 'x-koan', 'skt', '2011-09-24 15:48:30'),
(164, 'application', 'x-koan', 'skm', '2011-09-24 15:48:30'),
(165, 'application', 'x-kpresenter', 'kpr', '2011-09-24 15:48:30'),
(166, 'application', 'x-kpresenter', 'kpt', '2011-09-24 15:48:30'),
(167, 'application', 'x-kspread', 'ksp', '2011-09-24 15:48:30'),
(168, 'application', 'x-kword', 'kwd', '2011-09-24 15:48:30'),
(169, 'application', 'x-kword', 'kwt', '2011-09-24 15:48:30'),
(170, 'application', 'x-latex', 'latex', '2011-09-24 15:48:30'),
(171, 'application', 'x-lha', 'lha', '2011-09-24 15:48:30'),
(172, 'application', 'x-lyx', 'lyx', '2011-09-24 15:48:30'),
(173, 'application', 'x-lzh', 'lzh', '2011-09-24 15:48:30'),
(174, 'application', 'x-lzx', 'lzx', '2011-09-24 15:48:30'),
(175, 'application', 'x-maker', 'frm', '2011-09-24 15:48:30'),
(176, 'application', 'x-maker', 'maker', '2011-09-24 15:48:30'),
(177, 'application', 'x-maker', 'frame', '2011-09-24 15:48:30'),
(178, 'application', 'x-maker', 'fm', '2011-09-24 15:48:30'),
(179, 'application', 'x-maker', 'fb', '2011-09-24 15:48:30'),
(180, 'application', 'x-maker', 'book', '2011-09-24 15:48:30'),
(181, 'application', 'x-maker', 'fbdoc', '2011-09-24 15:48:30'),
(182, 'application', 'x-mif', 'mif', '2011-09-24 15:48:30'),
(183, 'application', 'x-ms-wmd', 'wmd', '2011-09-24 15:48:30'),
(184, 'application', 'x-ms-wmz', 'wmz', '2011-09-24 15:48:30'),
(185, 'application', 'x-msdos-program', 'com', '2011-09-24 15:48:30'),
(186, 'application', 'x-msdos-program', 'exe', '2011-09-24 15:48:30'),
(187, 'application', 'x-msdos-program', 'bat', '2011-09-24 15:48:30'),
(188, 'application', 'x-msdos-program', 'dll', '2011-09-24 15:48:30'),
(189, 'application', 'x-msi', 'msi', '2011-09-24 15:48:30'),
(190, 'application', 'x-netcdf', 'nc', '2011-09-24 15:48:30'),
(191, 'application', 'x-ns-proxy-autoconfig', 'pac', '2011-09-24 15:48:30'),
(192, 'application', 'x-ns-proxy-autoconfig', 'dat', '2011-09-24 15:48:30'),
(193, 'application', 'x-nwc', 'nwc', '2011-09-24 15:48:30'),
(194, 'application', 'x-object', 'o', '2011-09-24 15:48:30'),
(195, 'application', 'x-oz-application', 'oza', '2011-09-24 15:48:30'),
(196, 'application', 'x-pkcs7-certreqresp', 'p7r', '2011-09-24 15:48:30'),
(197, 'application', 'x-pkcs7-crl', 'crl', '2011-09-24 15:48:30'),
(198, 'application', 'x-python-code', 'pyc', '2011-09-24 15:48:30'),
(199, 'application', 'x-python-code', 'pyo', '2011-09-24 15:48:30'),
(200, 'application', 'x-qgis', 'qgs', '2011-09-24 15:48:30'),
(201, 'application', 'x-qgis', 'shp', '2011-09-24 15:48:30'),
(202, 'application', 'x-qgis', 'shx', '2011-09-24 15:48:30'),
(203, 'application', 'x-quicktimeplayer', 'qtl', '2011-09-24 15:48:30'),
(204, 'application', 'x-redhat-package-manager', 'rpm', '2011-09-24 15:48:30'),
(205, 'application', 'x-ruby', 'rb', '2011-09-24 15:48:30'),
(206, 'application', 'x-sh', 'sh', '2011-09-24 15:48:30'),
(207, 'application', 'x-shar', 'shar', '2011-09-24 15:48:30'),
(208, 'application', 'x-shockwave-flash', 'swf', '2011-09-24 15:48:30'),
(209, 'application', 'x-shockwave-flash', 'swfl', '2011-09-24 15:48:30'),
(210, 'application', 'x-stuffit', 'sit', '2011-09-24 15:48:30'),
(211, 'application', 'x-stuffit', 'sitx', '2011-09-24 15:48:30'),
(212, 'application', 'x-sv4cpio', 'sv4cpi', '2011-09-24 15:48:30'),
(213, 'application', 'x-sv4crc', 'sv4crc', '2011-09-24 15:48:30'),
(214, 'application', 'x-tar', 'tar', '2011-09-24 15:48:30'),
(215, 'application', 'x-tcl', 'tcl', '2011-09-24 15:48:30'),
(216, 'application', 'x-tex-gf', 'gf', '2011-09-24 15:48:30'),
(217, 'application', 'x-tex-pk', 'pk', '2011-09-24 15:48:30'),
(218, 'application', 'x-texinfo', 'texinf', '2011-09-24 15:48:30'),
(219, 'application', 'x-texinfo', 'texi', '2011-09-24 15:48:30'),
(220, 'application', 'x-trash', '~', '2011-09-24 15:48:30'),
(221, 'application', 'x-trash', '%', '2011-09-24 15:48:30'),
(222, 'application', 'x-trash', 'bak', '2011-09-24 15:48:30'),
(223, 'application', 'x-trash', 'old', '2011-09-24 15:48:30'),
(224, 'application', 'x-trash', 'sik', '2011-09-24 15:48:30'),
(225, 'application', 'x-troff', 't', '2011-09-24 15:48:30'),
(226, 'application', 'x-troff', 'tr', '2011-09-24 15:48:30'),
(227, 'application', 'x-troff', 'roff', '2011-09-24 15:48:30'),
(228, 'application', 'x-troff-man', 'man', '2011-09-24 15:48:30'),
(229, 'application', 'x-troff-me', 'me', '2011-09-24 15:48:30'),
(230, 'application', 'x-troff-ms', 'ms', '2011-09-24 15:48:30'),
(231, 'application', 'x-ustar', 'ustar', '2011-09-24 15:48:30'),
(232, 'application', 'x-wais-source', 'src', '2011-09-24 15:48:30'),
(233, 'application', 'x-wingz', 'wz', '2011-09-24 15:48:30'),
(234, 'application', 'x-x509-ca-cert', 'crt', '2011-09-24 15:48:30'),
(235, 'application', 'x-xcf', 'xcf', '2011-09-24 15:48:30'),
(236, 'application', 'x-xfig', 'fig', '2011-09-24 15:48:30'),
(237, 'application', 'x-xpinstall', 'xpi', '2011-09-24 15:48:30'),
(238, 'audio', 'amr', 'amr', '2011-09-24 15:48:30'),
(239, 'audio', 'amr-wb', 'awb', '2011-09-24 15:48:30'),
(240, 'audio', 'annodex', 'axa', '2011-09-24 15:48:30'),
(241, 'audio', 'basic', 'au', '2011-09-24 15:48:30'),
(242, 'audio', 'basic', 'snd', '2011-09-24 15:48:30'),
(243, 'audio', 'flac', 'flac', '2011-09-24 15:48:30'),
(244, 'audio', 'midi', 'mid', '2011-09-24 15:48:30'),
(245, 'audio', 'midi', 'midi', '2011-09-24 15:48:30'),
(246, 'audio', 'midi', 'kar', '2011-09-24 15:48:30'),
(247, 'audio', 'mpeg', 'mpga', '2011-09-24 15:48:30'),
(248, 'audio', 'mpeg', 'mpega', '2011-09-24 15:48:30'),
(249, 'audio', 'mpeg', 'mp2', '2011-09-24 15:48:30'),
(250, 'audio', 'mpeg', 'mp3', '2011-09-24 15:48:30'),
(251, 'audio', 'mpeg', 'm4a', '2011-09-24 15:48:30'),
(252, 'audio', 'mpegurl', 'm3u', '2011-09-24 15:48:30'),
(253, 'audio', 'ogg', 'oga', '2011-09-24 15:48:30'),
(254, 'audio', 'ogg', 'ogg', '2011-09-24 15:48:30'),
(255, 'audio', 'ogg', 'spx', '2011-09-24 15:48:30'),
(256, 'audio', 'prs.sid', 'sid', '2011-09-24 15:48:30'),
(257, 'audio', 'x-aiff', 'aif', '2011-09-24 15:48:30'),
(258, 'audio', 'x-aiff', 'aiff', '2011-09-24 15:48:30'),
(259, 'audio', 'x-aiff', 'aifc', '2011-09-24 15:48:30'),
(260, 'audio', 'x-gsm', 'gsm', '2011-09-24 15:48:30'),
(261, 'audio', 'x-mpegurl', 'm3u', '2011-09-24 15:48:30'),
(262, 'audio', 'x-ms-wma', 'wma', '2011-09-24 15:48:30'),
(263, 'audio', 'x-ms-wax', 'wax', '2011-09-24 15:48:30'),
(264, 'audio', 'x-pn-realaudio', 'ra', '2011-09-24 15:48:30'),
(265, 'audio', 'x-pn-realaudio', 'rm', '2011-09-24 15:48:30'),
(266, 'audio', 'x-pn-realaudio', 'ram', '2011-09-24 15:48:30'),
(267, 'audio', 'x-realaudio', 'ra', '2011-09-24 15:48:30'),
(268, 'audio', 'x-scpls', 'pls', '2011-09-24 15:48:30'),
(269, 'audio', 'x-sd2', 'sd2', '2011-09-24 15:48:30'),
(270, 'audio', 'x-wav', 'wav', '2011-09-24 15:48:30'),
(271, 'chemical', 'x-alchemy', 'alc', '2011-09-24 15:48:30'),
(272, 'chemical', 'x-cache', 'cac', '2011-09-24 15:48:30'),
(273, 'chemical', 'x-cache', 'cache', '2011-09-24 15:48:30'),
(274, 'chemical', 'x-cache-csf', 'csf', '2011-09-24 15:48:30'),
(275, 'chemical', 'x-cactvs-binary', 'cbin', '2011-09-24 15:48:30'),
(276, 'chemical', 'x-cactvs-binary', 'cascii', '2011-09-24 15:48:30'),
(277, 'chemical', 'x-cactvs-binary', 'ctab', '2011-09-24 15:48:30'),
(278, 'chemical', 'x-cdx', 'cdx', '2011-09-24 15:48:30'),
(279, 'chemical', 'x-cerius', 'cer', '2011-09-24 15:48:30'),
(280, 'chemical', 'x-chem3d', 'c3d', '2011-09-24 15:48:30'),
(281, 'chemical', 'x-chemdraw', 'chm', '2011-09-24 15:48:30'),
(282, 'chemical', 'x-cif', 'cif', '2011-09-24 15:48:30'),
(283, 'chemical', 'x-cmdf', 'cmdf', '2011-09-24 15:48:30'),
(284, 'chemical', 'x-cml', 'cml', '2011-09-24 15:48:30'),
(285, 'chemical', 'x-compass', 'cpa', '2011-09-24 15:48:30'),
(286, 'chemical', 'x-crossfire', 'bsd', '2011-09-24 15:48:30'),
(287, 'chemical', 'x-csml', 'csml', '2011-09-24 15:48:30'),
(288, 'chemical', 'x-csml', 'csm', '2011-09-24 15:48:30'),
(289, 'chemical', 'x-ctx', 'ctx', '2011-09-24 15:48:30'),
(290, 'chemical', 'x-cxf', 'cxf', '2011-09-24 15:48:30'),
(291, 'chemical', 'x-cxf', 'cef', '2011-09-24 15:48:30'),
(292, 'chemical', 'x-embl-dl-nucleotide', 'emb', '2011-09-24 15:48:30'),
(293, 'chemical', 'x-embl-dl-nucleotide', 'embl', '2011-09-24 15:48:30'),
(294, 'chemical', 'x-galactic-spc', 'spc', '2011-09-24 15:48:30'),
(295, 'chemical', 'x-gamess-input', 'inp', '2011-09-24 15:48:30'),
(296, 'chemical', 'x-gamess-input', 'gam', '2011-09-24 15:48:30'),
(297, 'chemical', 'x-gamess-input', 'gamin', '2011-09-24 15:48:30'),
(298, 'chemical', 'x-gaussian-checkpoint', 'fch', '2011-09-24 15:48:30'),
(299, 'chemical', 'x-gaussian-checkpoint', 'fchk', '2011-09-24 15:48:30'),
(300, 'chemical', 'x-gaussian-cube', 'cub', '2011-09-24 15:48:30'),
(301, 'chemical', 'x-gaussian-input', 'gau', '2011-09-24 15:48:30'),
(302, 'chemical', 'x-gaussian-input', 'gjc', '2011-09-24 15:48:30'),
(303, 'chemical', 'x-gaussian-input', 'gjf', '2011-09-24 15:48:30'),
(304, 'chemical', 'x-gaussian-log', 'gal', '2011-09-24 15:48:30'),
(305, 'chemical', 'x-gcg8-sequence', 'gcg', '2011-09-24 15:48:30'),
(306, 'chemical', 'x-genbank', 'gen', '2011-09-24 15:48:30'),
(307, 'chemical', 'x-hin', 'hin', '2011-09-24 15:48:30'),
(308, 'chemical', 'x-isostar', 'istr', '2011-09-24 15:48:30'),
(309, 'chemical', 'x-isostar', 'ist', '2011-09-24 15:48:30'),
(310, 'chemical', 'x-jcamp-dx', 'jdx', '2011-09-24 15:48:30'),
(311, 'chemical', 'x-jcamp-dx', 'dx', '2011-09-24 15:48:30'),
(312, 'chemical', 'x-kinemage', 'kin', '2011-09-24 15:48:30'),
(313, 'chemical', 'x-macmolecule', 'mcm', '2011-09-24 15:48:30'),
(314, 'chemical', 'x-macromodel-input', 'mmd', '2011-09-24 15:48:30'),
(315, 'chemical', 'x-macromodel-input', 'mmod', '2011-09-24 15:48:30'),
(316, 'chemical', 'x-mdl-molfile', 'mol', '2011-09-24 15:48:30'),
(317, 'chemical', 'x-mdl-rdfile', 'rd', '2011-09-24 15:48:30'),
(318, 'chemical', 'x-mdl-rxnfile', 'rxn', '2011-09-24 15:48:30'),
(319, 'chemical', 'x-mdl-sdfile', 'sd', '2011-09-24 15:48:30'),
(320, 'chemical', 'x-mdl-sdfile', 'sdf', '2011-09-24 15:48:30'),
(321, 'chemical', 'x-mdl-tgf', 'tgf', '2011-09-24 15:48:30'),
(322, 'chemical', 'x-mmcif', 'mcif', '2011-09-24 15:48:30'),
(323, 'chemical', 'x-mol2', 'mol2', '2011-09-24 15:48:30'),
(324, 'chemical', 'x-molconn-Z', 'b', '2011-09-24 15:48:30'),
(325, 'chemical', 'x-mopac-graph', 'gpt', '2011-09-24 15:48:30'),
(326, 'chemical', 'x-mopac-input', 'mop', '2011-09-24 15:48:30'),
(327, 'chemical', 'x-mopac-input', 'mopcrt', '2011-09-24 15:48:30'),
(328, 'chemical', 'x-mopac-input', 'mpc', '2011-09-24 15:48:30'),
(329, 'chemical', 'x-mopac-input', 'zmt', '2011-09-24 15:48:30'),
(330, 'chemical', 'x-mopac-out', 'moo', '2011-09-24 15:48:30'),
(331, 'chemical', 'x-mopac-vib', 'mvb', '2011-09-24 15:48:30'),
(332, 'chemical', 'x-ncbi-asn1', 'asn', '2011-09-24 15:48:30'),
(333, 'chemical', 'x-ncbi-asn1-ascii', 'prt', '2011-09-24 15:48:30'),
(334, 'chemical', 'x-ncbi-asn1-ascii', 'ent', '2011-09-24 15:48:30'),
(335, 'chemical', 'x-ncbi-asn1-binary', 'val', '2011-09-24 15:48:30'),
(336, 'chemical', 'x-ncbi-asn1-binary', 'aso', '2011-09-24 15:48:30'),
(337, 'chemical', 'x-ncbi-asn1-spec', 'asn', '2011-09-24 15:48:30'),
(338, 'chemical', 'x-pdb', 'pdb', '2011-09-24 15:48:30'),
(339, 'chemical', 'x-pdb', 'ent', '2011-09-24 15:48:30'),
(340, 'chemical', 'x-rosdal', 'ros', '2011-09-24 15:48:30'),
(341, 'chemical', 'x-swissprot', 'sw', '2011-09-24 15:48:30'),
(342, 'chemical', 'x-vamas-iso14976', 'vms', '2011-09-24 15:48:30'),
(343, 'chemical', 'x-vmd', 'vmd', '2011-09-24 15:48:30'),
(344, 'chemical', 'x-xtel', 'xtel', '2011-09-24 15:48:30'),
(345, 'chemical', 'x-xyz', 'xyz', '2011-09-24 15:48:30'),
(346, 'image', 'gif', 'gif', '2011-09-24 15:48:30'),
(347, 'image', 'ief', 'ief', '2011-09-24 15:48:30'),
(348, 'image', 'jpeg', 'jpeg', '2011-09-24 15:48:30'),
(349, 'image', 'jpeg', 'jpg', '2011-09-24 15:48:30'),
(350, 'image', 'jpeg', 'jpe', '2011-09-24 15:48:30'),
(351, 'image', 'pcx', 'pcx', '2011-09-24 15:48:30'),
(352, 'image', 'png', 'png', '2011-09-24 15:48:30'),
(353, 'image', 'svg+xml', 'svg', '2011-09-24 15:48:30'),
(354, 'image', 'svg+xml', 'svgz', '2011-09-24 15:48:30'),
(355, 'image', 'tiff', 'tiff', '2011-09-24 15:48:30'),
(356, 'image', 'tiff', 'tif', '2011-09-24 15:48:30'),
(357, 'image', 'vnd.djvu', 'djvu', '2011-09-24 15:48:30'),
(358, 'image', 'vnd.djvu', 'djv', '2011-09-24 15:48:30'),
(359, 'image', 'vnd.wap.wbmp', 'wbmp', '2011-09-24 15:48:30'),
(360, 'image', 'x-cmu-raster', 'ras', '2011-09-24 15:48:30'),
(361, 'image', 'x-coreldraw', 'cdr', '2011-09-24 15:48:30'),
(362, 'image', 'x-coreldrawpattern', 'pat', '2011-09-24 15:48:30'),
(363, 'image', 'x-coreldrawtemplate', 'cdt', '2011-09-24 15:48:30'),
(364, 'image', 'x-corelphotopaint', 'cpt', '2011-09-24 15:48:30'),
(365, 'image', 'x-icon', 'ico', '2011-09-24 15:48:30'),
(366, 'image', 'x-jg', 'art', '2011-09-24 15:48:30'),
(367, 'image', 'x-jng', 'jng', '2011-09-24 15:48:30'),
(368, 'image', 'x-ms-bmp', 'bmp', '2011-09-24 15:48:30'),
(369, 'image', 'x-photoshop', 'psd', '2011-09-24 15:48:30'),
(370, 'image', 'x-portable-anymap', 'pnm', '2011-09-24 15:48:30'),
(371, 'image', 'x-portable-bitmap', 'pbm', '2011-09-24 15:48:30'),
(372, 'image', 'x-portable-graymap', 'pgm', '2011-09-24 15:48:30'),
(373, 'image', 'x-portable-pixmap', 'ppm', '2011-09-24 15:48:30'),
(374, 'image', 'x-rgb', 'rgb', '2011-09-24 15:48:30'),
(375, 'image', 'x-xbitmap', 'xbm', '2011-09-24 15:48:30'),
(376, 'image', 'x-xpixmap', 'xpm', '2011-09-24 15:48:30'),
(377, 'image', 'x-xwindowdump', 'xwd', '2011-09-24 15:48:30'),
(378, 'message', 'rfc822', 'eml', '2011-09-24 15:48:30'),
(379, 'model', 'iges', 'igs', '2011-09-24 15:48:30'),
(380, 'model', 'iges', 'iges', '2011-09-24 15:48:30'),
(381, 'model', 'mesh', 'msh', '2011-09-24 15:48:30'),
(382, 'model', 'mesh', 'mesh', '2011-09-24 15:48:30'),
(383, 'model', 'mesh', 'silo', '2011-09-24 15:48:30'),
(384, 'model', 'vrml', 'wrl', '2011-09-24 15:48:30'),
(385, 'model', 'vrml', 'vrml', '2011-09-24 15:48:30'),
(386, 'text', 'calendar', 'ics', '2011-09-24 15:48:30'),
(387, 'text', 'calendar', 'icz', '2011-09-24 15:48:30'),
(388, 'text', 'css', 'css', '2011-09-24 15:48:30'),
(389, 'text', 'csv', 'csv', '2011-09-24 15:48:30'),
(390, 'text', 'h323', '323', '2011-09-24 15:48:30'),
(391, 'text', 'html', 'html', '2011-09-24 15:48:30'),
(392, 'text', 'html', 'htm', '2011-09-24 15:48:30'),
(393, 'text', 'html', 'shtml', '2011-09-24 15:48:30'),
(394, 'text', 'iuls', 'uls', '2011-09-24 15:48:30'),
(395, 'text', 'mathml', 'mml', '2011-09-24 15:48:30'),
(396, 'text', 'plain', 'asc', '2011-09-24 15:48:30'),
(397, 'text', 'plain', 'txt', '2011-09-24 15:48:30'),
(398, 'text', 'plain', 'text', '2011-09-24 15:48:30'),
(399, 'text', 'plain', 'pot', '2011-09-24 15:48:30'),
(400, 'text', 'plain', 'brf', '2011-09-24 15:48:30'),
(401, 'text', 'richtext', 'rtx', '2011-09-24 15:48:30'),
(402, 'text', 'scriptlet', 'sct', '2011-09-24 15:48:30'),
(403, 'text', 'scriptlet', 'wsc', '2011-09-24 15:48:30'),
(404, 'text', 'texmacs', 'tm', '2011-09-24 15:48:30'),
(405, 'text', 'texmacs', 'ts', '2011-09-24 15:48:30'),
(406, 'text', 'tab-separated-values', 'tsv', '2011-09-24 15:48:30'),
(407, 'text', 'vnd.sun.j2me.app-descriptor', 'jad', '2011-09-24 15:48:30'),
(408, 'text', 'vnd.wap.wml', 'wml', '2011-09-24 15:48:30'),
(409, 'text', 'vnd.wap.wmlscript', 'wmls', '2011-09-24 15:48:30'),
(410, 'text', 'x-bibtex', 'bib', '2011-09-24 15:48:30'),
(411, 'text', 'x-boo', 'boo', '2011-09-24 15:48:30'),
(412, 'text', 'x-c++hdr', 'h++', '2011-09-24 15:48:30'),
(413, 'text', 'x-c++hdr', 'hpp', '2011-09-24 15:48:30'),
(414, 'text', 'x-c++hdr', 'hxx', '2011-09-24 15:48:30'),
(415, 'text', 'x-c++hdr', 'hh', '2011-09-24 15:48:30'),
(416, 'text', 'x-c++src', 'c++', '2011-09-24 15:48:30'),
(417, 'text', 'x-c++src', 'cpp', '2011-09-24 15:48:30'),
(418, 'text', 'x-c++src', 'cxx', '2011-09-24 15:48:30'),
(419, 'text', 'x-c++src', 'cc', '2011-09-24 15:48:30'),
(420, 'text', 'x-chdr', 'h', '2011-09-24 15:48:30'),
(421, 'text', 'x-component', 'htc', '2011-09-24 15:48:30'),
(422, 'text', 'x-csh', 'csh', '2011-09-24 15:48:30'),
(423, 'text', 'x-csrc', 'c', '2011-09-24 15:48:30'),
(424, 'text', 'x-dsrc', 'd', '2011-09-24 15:48:30'),
(425, 'text', 'x-diff', 'diff', '2011-09-24 15:48:30'),
(426, 'text', 'x-diff', 'patch', '2011-09-24 15:48:30'),
(427, 'text', 'x-haskell', 'hs', '2011-09-24 15:48:30'),
(428, 'text', 'x-java', 'java', '2011-09-24 15:48:30'),
(429, 'text', 'x-literate-haskell', 'lhs', '2011-09-24 15:48:30'),
(430, 'text', 'x-moc', 'moc', '2011-09-24 15:48:30'),
(431, 'text', 'x-pascal', 'p', '2011-09-24 15:48:30'),
(432, 'text', 'x-pascal', 'pas', '2011-09-24 15:48:30'),
(433, 'text', 'x-pcs-gcd', 'gcd', '2011-09-24 15:48:30'),
(434, 'text', 'x-perl', 'pl', '2011-09-24 15:48:30'),
(435, 'text', 'x-perl', 'pm', '2011-09-24 15:48:30'),
(436, 'text', 'x-python', 'py', '2011-09-24 15:48:30'),
(437, 'text', 'x-scala', 'scala', '2011-09-24 15:48:30'),
(438, 'text', 'x-setext', 'etx', '2011-09-24 15:48:30'),
(439, 'text', 'x-sh', 'sh', '2011-09-24 15:48:30'),
(440, 'text', 'x-tcl', 'tcl', '2011-09-24 15:48:30'),
(441, 'text', 'x-tcl', 'tk', '2011-09-24 15:48:30'),
(442, 'text', 'x-tex', 'tex', '2011-09-24 15:48:30'),
(443, 'text', 'x-tex', 'ltx', '2011-09-24 15:48:30'),
(444, 'text', 'x-tex', 'sty', '2011-09-24 15:48:30'),
(445, 'text', 'x-tex', 'cls', '2011-09-24 15:48:30'),
(446, 'text', 'x-vcalendar', 'vcs', '2011-09-24 15:48:30'),
(447, 'text', 'x-vcard', 'vcf', '2011-09-24 15:48:30'),
(448, 'video', '3gpp', '3gp', '2011-09-24 15:48:30'),
(449, 'video', 'annodex', 'axv', '2011-09-24 15:48:30'),
(450, 'video', 'dl', 'dl', '2011-09-24 15:48:30'),
(451, 'video', 'dv', 'dif', '2011-09-24 15:48:30'),
(452, 'video', 'dv', 'dv', '2011-09-24 15:48:30'),
(453, 'video', 'fli', 'fli', '2011-09-24 15:48:30'),
(454, 'video', 'gl', 'gl', '2011-09-24 15:48:30'),
(455, 'video', 'mpeg', 'mpeg', '2011-09-24 15:48:30'),
(456, 'video', 'mpeg', 'mpg', '2011-09-24 15:48:30'),
(457, 'video', 'mpeg', 'mpe', '2011-09-24 15:48:30'),
(458, 'video', 'mp4', 'mp4', '2011-09-24 15:48:30'),
(459, 'video', 'quicktime', 'qt', '2011-09-24 15:48:30'),
(460, 'video', 'quicktime', 'mov', '2011-09-24 15:48:30'),
(461, 'video', 'ogg', 'ogv', '2011-09-24 15:48:30'),
(462, 'video', 'vnd.mpegurl', 'mxu', '2011-09-24 15:48:30'),
(463, 'video', 'x-flv', 'flv', '2011-09-24 15:48:30'),
(464, 'video', 'x-la-asf', 'lsf', '2011-09-24 15:48:30'),
(465, 'video', 'x-la-asf', 'lsx', '2011-09-24 15:48:30'),
(466, 'video', 'x-mng', 'mng', '2011-09-24 15:48:30'),
(467, 'video', 'x-ms-asf', 'asf', '2011-09-24 15:48:30'),
(468, 'video', 'x-ms-asf', 'asx', '2011-09-24 15:48:30'),
(469, 'video', 'x-ms-wm', 'wm', '2011-09-24 15:48:30'),
(470, 'video', 'x-ms-wmv', 'wmv', '2011-09-24 15:48:30'),
(471, 'video', 'x-ms-wmx', 'wmx', '2011-09-24 15:48:30'),
(472, 'video', 'x-ms-wvx', 'wvx', '2011-09-24 15:48:30'),
(473, 'video', 'x-msvideo', 'avi', '2011-09-24 15:48:30'),
(474, 'video', 'x-sgi-movie', 'movie', '2011-09-24 15:48:30'),
(475, 'video', 'x-matroska', 'mpv', '2011-09-24 15:48:30'),
(476, 'x-conference', 'x-cooltalk', 'ice', '2011-09-24 15:48:30'),
(477, 'x-epoc', 'x-sisx-app', 'sisx', '2011-09-24 15:48:30'),
(478, 'x-world', 'x-vrml', 'vrm', '2011-09-24 15:48:30'),
(479, 'x-world', 'x-vrml', 'vrml', '2011-09-24 15:48:30'),
(480, 'x-world', 'x-vrml', 'wrl', '2011-09-24 15:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pagetype_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_homepage` tinyint(1) NOT NULL,
  `title` varchar(128) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `visible_from` timestamp NULL DEFAULT NULL,
  `visible_to` timestamp NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uri` (`uri`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_page_id` (`parent_id`),
  KEY `fk_pagetype_id` (`pagetype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `user_id`, `pagetype_id`, `parent_id`, `is_homepage`, `title`, `uri`, `description`, `body`, `visible_from`, `visible_to`, `date`) VALUES
(20, 1, 1, 0, 1, 'Home', '', 'Home page', 'Hello world.', '2011-09-30 12:45:47', NULL, '2011-09-29 11:01:11'),
(34, 1, 4, 0, 0, 'About', 'about', 'About', '<p>test about page</p>', '2011-09-30 10:14:38', '2011-10-21 00:00:00', '2011-09-29 23:30:28'),
(35, 1, 4, 20, 0, 'TinyMCE Dojo Dijit inline popup dialogs', 'tinymce-dojo', 'TinyMCE Dojo Dijit inline popup dialogs', '<p>Following on from my <a href="../../../post/2365205144/tinymce-jquery-ui-inline-popups">original post</a> on how to create a custom TinyMCE inline popups plugin (using jQuery UI), I have now created the Dojo Dijit version.</p>\n<p>This plugin is directed at those who are already using Dijit as their UI library, and is intended to bring consistency to the interface. I have decided not to code the custom alert and confirm dialogs (as is with the original TinyMCE inline popups plugin), as I don''t see a real need to replace these default native system dialogs.</p>\n<p>You can check out the <a href="https://github.com/badsyntax/tinymce-custom-inlinepopups/tree/master/dojoinlinepopups">project on github</a>, or take a look at <a href="http://demos.badsyntax.co/tinymce-dojo-popups/">the demo</a>.</p>\n<p>Installation is straightforward:</p>\n<ol>\n<li>Ensure you have loaded the dojo library and theme</li>\n<li>Ensure you have loaded the dialog dijit</li>\n<li>Copy the ''dojoinlinepopups'' folder into the tinymce plugins directory</li>\n<li>Disable the ''inlinepopups'' plugin, and enable the ''dojoinlinepopups'' plugin when initiating tinymce.</li>\n<li>That is all! If you get stuck, refer to the demo!</li>\n</ol>\n<p>If you experience any issues, please leave a comment in the <a href="https://github.com/badsyntax/tinymce-custom-inlinepopups/issues">issue tracker</a>, or in the comment section below.</p>', '2011-09-30 10:14:38', '2011-09-30 10:14:38', '2011-09-29 23:39:08'),
(36, 1, 5, 0, 0, 'Site tags', 'tag', 'Site tags', '', '2011-09-30 10:14:38', '2011-09-30 10:14:38', '2011-09-30 00:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `pagetypes`
--

CREATE TABLE IF NOT EXISTS `pagetypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pagetypes`
--

INSERT INTO `pagetypes` (`id`, `template`, `name`, `description`, `date`) VALUES
(1, 'listing.php', 'Listing page', 'A listing template.', '2011-09-29 15:24:08'),
(4, 'page.php', 'Page', 'Displays a single page', '2011-09-30 00:11:47'),
(5, 'listing.php', 'Listing by tags', 'Displays a filtered list by tags', '2011-09-30 12:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `site_pages`
--
CREATE TABLE IF NOT EXISTS `site_pages` (
`id` int(11)
,`user_id` int(11)
,`pagetype_id` int(11)
,`parent_id` int(11)
,`is_homepage` tinyint(1)
,`title` varchar(128)
,`uri` varchar(255)
,`description` varchar(255)
,`body` text
,`visible_from` timestamp
,`visible_to` timestamp
,`date` timestamp
,`pagetype_template` varchar(32)
,`pagetype_name` varchar(32)
,`pagetype_description` text
,`user_email` varchar(127)
,`user_username` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `user_id`, `name`, `slug`, `date`) VALUES
(20, 0, 'ertretre', 'asdsadad', '2011-09-30 12:20:21'),
(21, 0, 'ertretre', 'dsfsfs', '2011-09-30 01:07:09'),
(22, 0, 'ertretre', '', '2011-09-29 09:53:27'),
(23, 0, '11112', '', '2011-09-29 13:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `tags_pages`
--

CREATE TABLE IF NOT EXISTS `tags_pages` (
  `page_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`page_id`,`tag_id`),
  KEY `roles_pages_ibfk_2` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags_pages`
--

INSERT INTO `tags_pages` (`page_id`, `tag_id`) VALUES
(20, 1),
(20, 2),
(20, 5),
(20, 6),
(20, 19),
(20, 20),
(20, 21),
(28, 7),
(29, 3),
(29, 4),
(29, 7),
(29, 8),
(33, 1),
(33, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_id` int(11) DEFAULT NULL,
  `oauth_provider` varchar(32) DEFAULT NULL,
  `openid_id` varchar(255) DEFAULT NULL,
  `email` varchar(127) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_id`, `oauth_provider`, `openid_id`, `email`, `username`, `password`, `logins`, `last_login`, `date`) VALUES
(1, NULL, NULL, NULL, 'demo@example.com', 'admin', '0a08cb18832d5caaf5c9e7b1f340c40894cb9ba295d5cdb50d', 0, 0, '2011-09-24 15:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_tokens`
--


-- --------------------------------------------------------

--
-- Structure for view `site_pages`
--
DROP TABLE IF EXISTS `site_pages`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `site_pages` AS select `page`.`id` AS `id`,`page`.`user_id` AS `user_id`,`page`.`pagetype_id` AS `pagetype_id`,`page`.`parent_id` AS `parent_id`,`page`.`is_homepage` AS `is_homepage`,`page`.`title` AS `title`,`page`.`uri` AS `uri`,`page`.`description` AS `description`,`page`.`body` AS `body`,`page`.`visible_from` AS `visible_from`,`page`.`visible_to` AS `visible_to`,`page`.`date` AS `date`,`pagetype`.`template` AS `pagetype_template`,`pagetype`.`name` AS `pagetype_name`,`pagetype`.`description` AS `pagetype_description`,`user`.`email` AS `user_email`,`user`.`username` AS `user_username` from ((`pages` `page` join `pagetypes` `pagetype` on((`page`.`pagetype_id` = `pagetype`.`id`))) join `users` `user` on((`page`.`user_id` = `user`.`id`))) where ((`page`.`visible_from` <= now()) and (isnull(`page`.`visible_to`) or (`page`.`visible_to` >= now())));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

