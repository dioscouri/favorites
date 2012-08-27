CREATE TABLE IF NOT EXISTS `#__favorites_config` (
  `config_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `config_name` VARCHAR(255) NOT NULL ,
  `value` TEXT NOT NULL ,
  PRIMARY KEY (`config_id`) )
ENGINE=MyISAM 
DEFAULT CHARACTER SET utf8;

INSERT IGNORE INTO `#__favorites_config` (`config_id`, `config_name`, `value`) VALUES
(1, 'favorites_can_edit', '0');

CREATE TABLE IF NOT EXISTS `#__favorites_items` (
	 `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `lastmodified` datetime DEFAULT NULL,
  `params` varchar(255) NOT NULL,
  `enabled` tinyint(4) NOT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `scope_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=MyISAM 
DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `#__favorites_scopes` (
  `scope_id` int(11) NOT NULL AUTO_INCREMENT,
  `scope_name` varchar(255) NOT NULL COMMENT 'Plain English name for the scope',
  `scope_identifier` varchar(255) NOT NULL COMMENT 'String unique ID for the scope',
  `scope_url` varchar(255) NOT NULL COMMENT 'URL for the scope item',
  `scope_table` varchar(255) NOT NULL COMMENT 'The DB table to perform the JOIN',
  `scope_table_field` varchar(255) NOT NULL COMMENT 'The DB table field to use for the JOIN',
  `scope_table_name_field` varchar(255) NOT NULL COMMENT 'The DB table field to use for the item name',
  `scope_params` text NOT NULL COMMENT 'JSON-encoded object with any other information you want to store about the scope',
  PRIMARY KEY (`scope_id`),
  KEY `scope_identifier` (`scope_identifier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


