-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2014 at 07:05 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `musicmanager`
--

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
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `libraries`
--

CREATE TABLE IF NOT EXISTS `libraries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linktypeid` int(11) NOT NULL,
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
  `statusid` int(11) NOT NULL,
  `date_added` date DEFAULT NULL,
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
-- Table structure for table `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `genreid` int(11) NOT NULL DEFAULT '1',
  `length` time NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `genreid` (`genreid`)
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
-- Table structure for table `tracks_keywords`
--

CREATE TABLE IF NOT EXISTS `tracks_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trackid` int(11) NOT NULL,
  `keywordid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trackid` (`trackid`,`keywordid`)
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
