-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2013 年 10 月 23 日 13:42
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_lkdzs`
--

-- --------------------------------------------------------

--
-- 表的结构 `wechat_wall_comment`
--

CREATE TABLE IF NOT EXISTS `wechat_wall_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(30) NOT NULL,
  `content` varchar(420) NOT NULL,
  `color` varchar(100) NOT NULL,
  `eid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `wechat_wall_content`
--

CREATE TABLE IF NOT EXISTS `wechat_wall_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `author` varchar(250) NOT NULL,
  `tag` varchar(250) NOT NULL,
  `des` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `class` int(11) NOT NULL,
  `color` varchar(100) NOT NULL,
  `ext` varchar(250) NOT NULL,
  `top` int(11) NOT NULL,
  `click` int(11) NOT NULL,
  `good` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
