-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 25, 2014 at 01:23 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `musicmanager`
--
CREATE DATABASE IF NOT EXISTS `musicmanager` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `musicmanager`;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE IF NOT EXISTS `collections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collections_tracks`
--

CREATE TABLE IF NOT EXISTS `collections_tracks` (
  `collectionid` int(11) NOT NULL,
  `trackid` int(11) NOT NULL,
  KEY `collectionid` (`collectionid`,`trackid`),
  KEY `trackid` (`trackid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emotions`
--

CREATE TABLE IF NOT EXISTS `emotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `color` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `libraries`
--

CREATE TABLE IF NOT EXISTS `libraries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linktypeid` int(11) NULL DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `url` varchar(60) NOT NULL,
  `color` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `libraries_tracks`
--

CREATE TABLE IF NOT EXISTS `libraries_tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trackid` int(11) NOT NULL,
  `libraryid` int(11) NOT NULL,
  `statusid` int(11) NOT NULL DEFAULT '1',
  `date_added` date DEFAULT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trackid` (`trackid`,`libraryid`),
  KEY `statusid` (`statusid`),
  KEY `libraryid` (`libraryid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `libraries_tracks_statuses`
--

CREATE TABLE IF NOT EXISTS `libraries_tracks_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `trackid` int(11) NOT NULL,
  `versionid` int(11) NOT NULL,
  `libraryid` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payout` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trackid` (`trackid`,`versionid`),
  KEY `libraryid` (`libraryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `genreid` int(11) NOT NULL DEFAULT '1',
  `length` time NOT NULL,
  `date` date NOT NULL,
  `statusid` int(11) NOT NULL,
  `keywords` TEXT NULL,
  PRIMARY KEY (`id`),
  KEY `genreid` (`genreid`),
  KEY `statusid` (`statusid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracks_emotions`
--

CREATE TABLE IF NOT EXISTS `tracks_emotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trackid` int(11) NOT NULL,
  `emotionid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trackid` (`trackid`,`emotionid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracks_links`
--

CREATE TABLE IF NOT EXISTS `tracks_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musicid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `siteid` varchar(30) NOT NULL,
  `filename` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typeid` (`typeid`),
  KEY `siteid` (`siteid`),
  KEY `musicid` (`musicid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracks_linktypes`
--

CREATE TABLE IF NOT EXISTS `tracks_linktypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linktype` varchar(50) NOT NULL,
  `url` varchar(80) NOT NULL,
  `embed` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracks_versions`
--

CREATE TABLE IF NOT EXISTS `tracks_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `versionid` int(11) NOT NULL,
  `trackid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `versionid` (`versionid`,`trackid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(120) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE IF NOT EXISTS `versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
