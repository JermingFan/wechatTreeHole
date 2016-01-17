<?php
include '../inc/config_w.php';

if(!ip_access_limit()){
    die('cs');
}

$title=$_POST['title'];
$author=$_POST['author'];
$tag=$_POST['tag'];
$des=$_POST['des'];
$content=$_POST['content'];
$class=$_POST['class'];
$color=$_POST['color'];
$ext=$_POST['ext'];

if(!get_magic_quotes_gpc()){
    $title= addslashes($_POST['title']);
    $author= addslashes($_POST['author']);
    $tag= addslashes($_POST['tag']);
    $des= addslashes($_POST['des']);
    $content= addslashes($_POST['content']);
    $class= (int)addslashes($_POST['class']);
    $color= addslashes($_POST['color']);
    $ext= addslashes($_POST['ext']);
}
if(ltrim($content)){
    $error=-11;
    $link=mysql_connect(HOST.':'.PORT,USER,PASSWORD);
    if($link){
        mysql_select_db(DATABASE,$link);

        mysql_query("INSERT INTO `".WALL."` SET `title` = '".$title."', `author` = '".$author."', `tag` = '".$tag."', `des` = '".$des."', `content` = '".$content."', `class` = '".$class."', `color` = '".$color."', `ext` = '".$ext."', `ctime`= '".time()."',`top` = '0', `click` = '0', `good` = '0', `time` = '".time()."'");
        $error= mysql_errno();

    }
}else $error = -1;

echo $error;

function ip_access_limit(){
    defined('IP_ACCESS_INTERVAL') || define('IP_ACCESS_INTERVAL', 5);
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')){
        $userip = getenv('HTTP_CLIENT_IP');
    }elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')){
        $userip = getenv('HTTP_X_FORWARDED_FOR');
    }elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')){
        $userip = getenv('REMOTE_ADDR');
    }elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')){
        $userip = $_SERVER['REMOTE_ADDR'];
    }

    session_id(md5($userip));
    session_start();

    if(isset($_SESSION['time'])){
        $last_time = $_SESSION['time'];
        if((time() - $last_time) < IP_ACCESS_INTERVAL){
            $_SESSION['time'] = time();
            return false;
        }
    }

    $_SESSION['time'] = time();
    return true;
}