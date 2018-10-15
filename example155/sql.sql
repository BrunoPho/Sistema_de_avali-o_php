CREATE TABLE IF NOT EXISTS `s155_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `when` int(11) NOT NULL default '0',
  `rate` float NOT NULL,
  `rate_count` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `s155_items` (`title`, `description`, `when`, `rate`, `rate_count`) VALUES 
('Item #1', 'Here are you can put description of Item #1', UNIX_TIMESTAMP(), '0', '0'),
('Item #2', 'Here are you can put description of Item #2', UNIX_TIMESTAMP()+1, '0', '0'),
('Item #3', 'Here are you can put description of Item #3', UNIX_TIMESTAMP()+2, '0', '0'),
('Item #4', 'Here are you can put description of Item #4', UNIX_TIMESTAMP()+3, '0', '0'),
('Item #5', 'Here are you can put description of Item #5', UNIX_TIMESTAMP()+4, '0', '0');

CREATE TABLE `s155_items_vote_track` (
  `item_id` int(11) unsigned NOT NULL default '0',
  `ip` varchar(20) default NULL,
  `date` datetime default NULL,
  KEY `med_ip` (`ip`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;