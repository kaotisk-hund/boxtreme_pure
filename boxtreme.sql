-- phpMyAdmin SQL Dump
-- version 4.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2015 at 08:00 PM
-- Server version: 5.5.40-MariaDB
-- PHP Version: 5.5.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `boxtreme`
--

--
-- Dumping data for table `bx_Admin`
--

INSERT INTO `bx_Admin` (`id`, `user_id`) VALUES
(1, 1);

--
-- Dumping data for table `bx_Categories`
--

INSERT INTO `bx_Categories` (`id`, `category`) VALUES
(1, 'general'),
(2, 'news'),
(3, 'events');

--
-- Dumping data for table `bx_Footer`
--

INSERT INTO `bx_Footer` (`id`, `text`) VALUES
(1, '<a href="?lel">Lel link</a>'),
(2, '<b>Hello there!!</b>');

--
-- Dumping data for table `bx_Links`
--

INSERT INTO `bx_Links` (`id`, `link`, `title`) VALUES
(1, 'http://mta-radio.tk', 'MTA-Radio'),
(3, 'http://forum.mta-radio.tk', 'Forum'),
(4, 'http://chaoticmind.tk', 'Chaotic Mind'),
(5, 'http://villasofiaprines.gr', 'Villa Sofia'),
(6, 'http://chaoticmind.tk/boxtreme', 'BoxTreme News'),
(7, 'https://github.com/kaotisk-hund', 'GitHub');

--
-- Dumping data for table `bx_Posts`
--

INSERT INTO `bx_Posts` (`id`, `user_id`, `public`, `date`, `title`, `content`, `category_id`) VALUES
(1, 1, 1, '2015-01-04', 'Welcome at BoxTreme!!!', 'The old blah blah blah post is now our home page! You can set another post for view from ''Administrator'' menu :-)\r\n\r\nEnjoy!', 2),
(25, 1, 1, '2015-01-10', 'New class: Category', 'Class Category is a categories handler', 2),
(26, 1, 1, '2015-01-13', 'hey', 'asy', 0),
(27, 1, 1, '2015-01-24', 'adfd', 'dfasdf', 0);

--
-- Dumping data for table `bx_Prefs`
--

INSERT INTO `bx_Prefs` (`id`, `user_id`, `TorrentShare`, `Posts`) VALUES
(2, 1, 1, 0),
(3, 3, 1, 0);

--
-- Dumping data for table `bx_Settings`
--

INSERT INTO `bx_Settings` (`id`, `what`, `data`) VALUES
(1, 'site_name', 'BoxTreme'),
(2, 'site_title', 'BoxTreme');

--
-- Dumping data for table `bx_User`
--

INSERT INTO `bx_User` (`id`, `username`, `password`, `email`, `prefs_id`) VALUES
(1, 'boxer', 'boxer', 'kaotisk@desktop.lan', 2),
(2, 'boxer2', '123123', 'asd@as.jh', 0),
(3, 'bx', 'bxbx', 'bxw@vcvx.cd', NULL),
(4, 'boxeradfas', 'boxer', 'dsfa@da.hg', 0),
(5, 'boxer13', 'boxer', 'boxer@bb.cc', 0),
(6, 'boxer1234', 'boxer', 'dsfa@da.hg', 0),
(7, 'boxer345367456745', 'boxer', 'dsfa@da.hg', 0),
(8, 'boxer5454545454', 'boxer', '2121@kds.fg', 0),
(9, 'boxerasdasdasdasdas', 'boxerdasdasdasd', 'boxer@bb.cc', 0),
(10, 'boxer34ghvs5', 'boxer', 'boxer@bb.cc', 0),
(11, 'boxerhjdghjd', 'boxerdghjghjg', 'fda@sda.jh', 0),
(12, 'boxerasdasdas', 'boxerasdasdasd', '2121@kds.fg', 0),
(13, 'boxerasdfasdfa', 'boxersdfasdfaf', 'afgadfga@da.ffff', 0),
(14, 'santra', 'santra', 'santra@santra.st', 0),
(15, 'santra', 'santra', 'santra@santra.st', 0),
(16, 'boxerdfasdfafadfsdfewqetq', 'boxer', 'boxer@bb.cc', 0),
(17, 'boxer44', 'boxer', 'boxer@bb.cc', 0),
(18, 'blakas', 'boxer', 'ccc2007chaos@gmail.com', 0),
(19, 'yians', '1234', 'denexei@mail.akoma', 0),
(20, 'ed', '12', 'ccc2007chaos@gmail.com', 0),
(21, 'fart', '123', 'eer@re.ld', 0),
(22, 'kudkfha', 'dfjaksjdks', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
