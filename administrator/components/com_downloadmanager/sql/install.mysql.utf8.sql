
CREATE TABLE IF NOT EXISTS `#__dm_categories` (
`cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url_key` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `package_count` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `meta_data` text NOT NULL,
    PRIMARY KEY (`cid`)
);


CREATE TABLE IF NOT EXISTS `#__dm_packages` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `excerpt` text NOT NULL,
  `link_label` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `quota` int(11) NOT NULL,
  `show_quota` tinyint(11) NOT NULL,
  `show_counter` tinyint(1) NOT NULL,
  `access` text NOT NULL,
  `template` varchar(100) NOT NULL,
  `category` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `preview` varchar(255) NOT NULL,
  `files` text NOT NULL,
  `sourceurl` text NOT NULL,
  `download_count` int(11) NOT NULL,
  `page_template` varchar(255) NOT NULL,
  `url_key` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `meta_data` text NOT NULL,
  `package_size` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `#__dm_settings` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
    PRIMARY KEY (`id`)
);
 