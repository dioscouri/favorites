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
	`id` int NOT NULL AUTO_INCREMENT,
	`type` text NOT NULL,
	`name` text NOT NULL,
	`url` varchar(255) ,
	`user_id` int NOT NULL,
	`datecreated` datetime NOT NULL,
	`lastmodified` datetime,
	`params` varchar(255) NOT NULL,
	`enabled` tinyint NOT NULL,
	PRIMARY KEY (`id`)
)
ENGINE=MyISAM 
DEFAULT CHARACTER SET utf8;