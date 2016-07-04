-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 06 月 05 日 16:51
-- 服务器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `game`
--

-- --------------------------------------------------------

--
-- 表的结构 `equipment_pack`
--

CREATE TABLE IF NOT EXISTS `equipment_pack` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `gear_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `power_value` smallint(3) NOT NULL,
  `stamina_value` smallint(3) NOT NULL,
  `equip` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `power_id` tinyint(2) NOT NULL,
  `stamina_id` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `equipment_pack`
--

INSERT INTO `equipment_pack` (`id`, `gear_name`, `power_value`, `stamina_value`, `equip`, `power_id`, `stamina_id`) VALUES
(1, '破亂又脆弱的劍', 10, 10, 'Y', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `main_properties`
--

CREATE TABLE IF NOT EXISTS `main_properties` (
  `ID` tinyint(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `power_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `powe_value` smallint(5) NOT NULL,
  `stamina_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `stamina_value` smallint(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `main_properties`
--

INSERT INTO `main_properties` (`ID`, `power_name`, `powe_value`, `stamina_name`, `stamina_value`) VALUES
(01, '破亂', 10, '脆弱', 10),
(02, '不堪', 20, '生鏽', 20),
(03, '像樹枝', 30, '發霉', 30),
(04, '普通', 40, '平常', 40),
(05, '爪尖', 50, '皮厚', 50),
(06, '優良', 60, '卓越', 60),
(07, '老練', 70, '堅強', 70),
(08, '濺血', 80, '鑽石', 80),
(09, '神聖', 90, '永恆', 90),
(10, '傳奇', 100, '不朽', 100);

-- --------------------------------------------------------

--
-- 表的结构 `mob_properties`
--

CREATE TABLE IF NOT EXISTS `mob_properties` (
  `id` tinyint(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `mob_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `power_bonus` float(3,2) unsigned zerofill NOT NULL,
  `stamina_bonus` float(3,2) unsigned zerofill NOT NULL,
  `mob_pic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `mob_properties`
--

INSERT INTO `mob_properties` (`id`, `mob_name`, `power_bonus`, `stamina_bonus`, `mob_pic`) VALUES
(01, '史萊姆', 0.50, 0.50, 'img/slam.jpg'),
(02, '狼', 0.60, 0.60, 'img/wolfs.jpg'),
(03, '哥不靈', 0.70, 0.70, 'img/gblin.gif'),
(04, '扒手', 0.80, 0.80, 'img/theif.jpg'),
(05, '盜賊', 0.90, 0.90, 'img/robber.gif'),
(06, '大盜賊', 1.00, 1.00, 'img/bigrobber.gif'),
(07, '獸人', 1.10, 1.10, 'img/orc.gif'),
(08, '武裝獸人', 1.20, 1.20, 'img/armarorc.gif'),
(09, '獸人酋長', 1.30, 1.30, 'img/srm.gif'),
(10, '盜賊頭目', 1.40, 1.40, 'img/robberking.gif');

-- --------------------------------------------------------

--
-- 表的结构 `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `point` int(5) unsigned zerofill NOT NULL,
  `gear` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `rank`
--

INSERT INTO `rank` (`id`, `name`, `point`, `gear`) VALUES
(025, 'jack', 00130, '傳奇又不朽的劍'),
(026, 'henny', 00131, '傳奇又不朽的劍'),
(027, 'AAA3', 00101, 'dusk'),
(028, 'noob', 00002, '不堪又皮厚的劍'),
(029, 'noob2', 00002, '破亂又生鏽的劍'),
(030, 'noob3', 00003, '破亂又脆弱的劍');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
