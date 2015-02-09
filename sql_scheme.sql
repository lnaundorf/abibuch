-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `actionLog`;
CREATE TABLE `actionLog` (
  `id` int(20) NOT NULL auto_increment,
  `user` int(11) NOT NULL,
  `action` varchar(75) NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(30) NOT NULL auto_increment,
  `von` int(10) NOT NULL,
  `nach` int(10) NOT NULL,
  `text` varchar(175) NOT NULL,
  `nett` int(10) unsigned NOT NULL,
  `fies` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lehrer`;
CREATE TABLE `lehrer` (
  `id` int(11) NOT NULL auto_increment,
  `geschlecht` varchar(10) NOT NULL,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lehrerVoteList`;
CREATE TABLE `lehrerVoteList` (
  `id` int(10) NOT NULL auto_increment,
  `voteString` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lehrerVoteStat`;
CREATE TABLE `lehrerVoteStat` (
  `id` int(20) NOT NULL auto_increment,
  `voteId` int(10) unsigned NOT NULL,
  `von` int(10) unsigned NOT NULL,
  `lehrer` int(20) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `longcomments`;
CREATE TABLE `longcomments` (
  `id` int(20) NOT NULL auto_increment,
  `vonID` int(11) NOT NULL,
  `nach` int(11) NOT NULL,
  `vonName` varchar(50) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `newFeatures`;
CREATE TABLE `newFeatures` (
  `id` int(11) NOT NULL auto_increment,
  `featureString` text NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `visibleFor` int(11) NOT NULL default '0',
  `reihenfolge` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `notFoundErrors`;
CREATE TABLE `notFoundErrors` (
  `id` int(11) NOT NULL auto_increment,
  `request` varchar(100) NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `paarVoteList`;
CREATE TABLE `paarVoteList` (
  `id` int(10) NOT NULL auto_increment,
  `voteString` varchar(40) NOT NULL,
  `type1` varchar(1) NOT NULL,
  `type2` varchar(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `paarVoteStat`;
CREATE TABLE `paarVoteStat` (
  `id` int(20) NOT NULL auto_increment,
  `voteId` int(10) unsigned NOT NULL,
  `voting` int(10) unsigned NOT NULL,
  `wahl_m` int(10) unsigned NOT NULL,
  `wahl_w` int(10) unsigned NOT NULL,
  `voteString` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `quotes`;
CREATE TABLE `quotes` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `value` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `steckbriefList`;
CREATE TABLE `steckbriefList` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(70) NOT NULL,
  `reihenfolge` int(11) NOT NULL,
  `type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `steckbriefStat`;
CREATE TABLE `steckbriefStat` (
  `id` int(20) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userID` (`userID`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` text,
  `last_name` text,
  `lastonline` datetime NOT NULL,
  `rights` int(11) unsigned NOT NULL,
  `geschlecht` varchar(1) NOT NULL,
  `babybild_status` smallint(6) unsigned NOT NULL default '0',
  `jetztbild_status` smallint(6) unsigned NOT NULL default '0',
  `visible` tinyint(1) NOT NULL,
  `baby_activated_by` int(11) unsigned NOT NULL,
  `jetzt_activated_by` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `voteList`;
CREATE TABLE `voteList` (
  `id` int(10) NOT NULL auto_increment,
  `voteString` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `voteStat`;
CREATE TABLE `voteStat` (
  `id` int(30) NOT NULL auto_increment,
  `voteid` int(20) NOT NULL,
  `voting` int(20) NOT NULL,
  `voted` int(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 2015-02-09 15:06:07
