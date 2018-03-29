DROP TABLE IF EXISTS `#__books`;

CREATE TABLE `#__books` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10)     NOT NULL DEFAULT '0',
	`title` VARCHAR(25) NOT NULL,
	`author` VARCHAR(25) NOT NULL,
	`publisher` VARCHAR(25) NOT NULL,
	`category` VARCHAR(25) NOT NULL,
	`year`       INT(11)     NOT NULL,
	`status` VARCHAR(25) NOT NULL DEFAULT 'free',
	`createDate` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`rentDate` DATETIME DEFAULT NULL,
	`published` tinyint(4) NOT NULL DEFAULT '1',
	`params`   VARCHAR(1024) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

INSERT INTO `#__books` (`title`,`author`, `publisher`, `category`, `year`) VALUES
('Pan Lodowego Ogrodu','Jaroslaw Grzedowicz','Trzy Sowy','sience-fiction','2012'),
('Game','Andres de la Motte ','Swiat','sience-fiction','2010');