-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 03, 2013 at 03:08 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `nockbits`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_admin`
-- 

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int(11) NOT NULL auto_increment,
  `adname` varchar(255) NOT NULL,
  `adusername` varchar(100) NOT NULL,
  `adpassword` varchar(100) NOT NULL,
  `adstatus` tinyint(1) NOT NULL default '0',
  `adgroup` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_articles`
-- 

CREATE TABLE IF NOT EXISTS `tbl_articles` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `aparent` int(11) NOT NULL default '0',
  `atitle` varchar(255) NOT NULL,
  `asefurl` varchar(255) NOT NULL,
  `ashortdesc` text NOT NULL,
  `adesc` longtext NOT NULL,
  `ametadesc` text NOT NULL,
  `ametakeywords` text NOT NULL,
  `aimg` varchar(255) NOT NULL,
  `amedia` varchar(255) NOT NULL,
  `astatus` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `atitle` (`atitle`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_contacts`
-- 

CREATE TABLE IF NOT EXISTS `tbl_contacts` (
  `id` int(11) NOT NULL auto_increment,
  `cto` varchar(255) NOT NULL,
  `csubject` text NOT NULL,
  `cmailbody` text NOT NULL,
  `cresponse` tinyint(1) NOT NULL default '0',
  `cstatus` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `cto` (`cto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_enquiry`
-- 

CREATE TABLE IF NOT EXISTS `tbl_enquiry` (
  `id` int(11) NOT NULL auto_increment,
  `enname` varchar(255) NOT NULL,
  `enemail` varchar(255) NOT NULL,
  `enphone` varchar(25) NOT NULL,
  `enaddress` text NOT NULL,
  `enpostcode` varchar(10) NOT NULL,
  `enstate` varchar(255) NOT NULL,
  `encountry` varchar(255) NOT NULL,
  `encomment` text NOT NULL,
  `enip` varchar(25) NOT NULL,
  `enref` varchar(255) NOT NULL,
  `enuseragent` text NOT NULL,
  `enstatus` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_subscriber`
-- 

CREATE TABLE IF NOT EXISTS `tbl_subscriber` (
  `id` int(11) NOT NULL auto_increment,
  `subname` varchar(255) NOT NULL,
  `subemail` varchar(255) NOT NULL,
  `subcat` tinyint(1) NOT NULL default '1',
  `substatus` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_subscription`
-- 

CREATE TABLE IF NOT EXISTS `tbl_subscription` (
  `id` int(11) NOT NULL auto_increment,
  `subtitle` varchar(255) NOT NULL,
  `subcode` varchar(50) NOT NULL,
  `subdesc` text NOT NULL,
  `subeditor` varchar(255) NOT NULL,
  `subpub` varchar(255) NOT NULL,
  `subpubdt` date NOT NULL,
  `subprice` double(10,2) NOT NULL,
  `subimg` varchar(255) NOT NULL,
  `submedia` varchar(255) NOT NULL,
  `substatus` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
