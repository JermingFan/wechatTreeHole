<?php
include 'inc/config_w.php';
header("Content-Type:text/html;charset=utf-8");
$link = mysql_connect(HOST.':'.PORT,USER,PASSWORD);
if($link){
    mysql_select_db(DATABASE,$link);
    mysql_query("set names 'utf8'");
    mysql_query("CREATE TABLE IF NOT EXISTS `".WALL_COMMENT."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(30) NOT NULL,
  `content` varchar(420) NOT NULL,
  `color` varchar(100) NOT NULL,
  `eid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    echo mysql_errno();

    mysql_query("CREATE TABLE IF NOT EXISTS `".WALL."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `author` varchar(250) NOT NULL,
  `tag` varchar(250) NOT NULL,
  `des` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `class` int(11) NOT NULL,
  `color` varchar(100) NOT NULL,
  `ext` varchar(250) NOT NULL,
  `top` int(11) default 0,
  `click` int(11) default 0,
  `good` int(11) default 0,
  `ctime` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
    echo mysql_errno();

    echo "<br />看到全部为0即安装成功";
}else{
    die("链接数据库失败");
}
