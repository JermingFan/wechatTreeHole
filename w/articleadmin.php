<?php
require('../inc/config_w.php');
require('../inc/setsmarty.php');
require('../inc/ubb.php');
require('../inc/data_w.php');

function key_match($keyw,$stra,$e = false){
    #e参数，是否完全匹配

    $r = false;

    foreach($stra as $key){
        if($e){
            if($key == $keyw){
                $r = true;
                break;
            }
        }else{
            if(preg_match('|'.$key.'|ism',$keyw)){
                $r = true;
                break;
            }
        }
    }
    return $r;
}

$ua = $_SERVER['HTTP_USER_AGENT'];

if(key_match($ua,array(
    'Android.1.1',
    'Android.1.6',
    'Android.2.0',
    'Android.2.1',
    'Android.2.2',
    'Android.2.3',
    'Android.3.0',
    'Android.3.1',
    'Android.3.2',
    'Android.4.0'
))) $css = 'mobile_l.css?t='.time();
else $css = 'mobile.css?t='.time();

$yzblog = new smarty_yzblog();
$yzblog->setTemplateDir('../tpl/w/');

$type=$_GET['type'];
$id=(int)$_GET['id'];

$con = getdata($type,0,$id);
if(!count($con)) die('Id error!');

$text=nl2br(htmlspecialchars($con[0]['content']));

#ubb放在这之后
if($con[0]['type'] == "article") $text=straddubb($text);

$link=mysql_connect(HOST.':'.PORT,USER,PASSWORD);
if($link){
    mysql_select_db(DATABASE,$link);
    mysql_query('UPDATE '.WALL.' SET click='.($con[0]['click']+1).' where id='.$con[0]['id']);

}

$comment=getdata('comment',0,"",$id);

$c=count($comment);
if($c){
    for($i=0;$i<$c;++$i){
        $comment[$i]['title']= htmlspecialchars( $comment[$i]['title'],ENT_QUOTES);
        $comment[$i]['des']= htmlspecialchars( $comment[$i]['des'],ENT_QUOTES);

        $a = 'div';
        $view = '';
        $str .= '<'.$a.' class="item" style="background:'.$comment[$i]['color'].';" href="article.php?id='.$comment[$i]['id'].'"><img class="point" src="../img/point.png" /><div class="num none">'.($i+$first+1).'</div><div class="view left">#'.$comment[$i]['lou'].'</div>'.$view.'<div class="time right"><span class="timed">'.date('d',$comment[$i]['time']).'</span>日<span class="timem">'.date('m',$comment[$i]['time']).'</span>月'.date('Y年 D H:i',$comment[$i]['time']).'</div><h1 class="title">'.$comment[$i]['title'].'</h1><div class="des feeling">'.$comment[$i]['des'].'</div><br /><a style="color: #fff;" href="delc.php?id='.$comment[$i]['id'].'">删除它</a></'.$a.'>';
    }
}else{
    $note= '没有评论，来一条吧～';
}
$tttt = "树洞";
if($con[0]['class']<1000) $tttt = "心愿";
if($con[0]['class']>2000) $tttt = "表白";

if(!ltrim($con[0]['author'])) $con[0]['title']="匿名";

$yzblog->assign('title','微信墙后台管理');
$yzblog->assign('tttt',$tttt);
$yzblog->assign('id',$con[0]['id']);
$yzblog->assign('t', htmlspecialchars($con[0]['title']));
$yzblog->assign('author', htmlspecialchars($con[0]['author']));
$yzblog->assign('ext', htmlspecialchars($con[0]['ext']));
$yzblog->assign('time',date('H:i:s Y年m月d日 D',$con[0]['time']));
$yzblog->assign('text',$text.'<br /><br /><a style="color: red;" href="del.php?id='.$con[0]['id'].'">删除文章</a>');
$yzblog->assign('color',$con[0]['color']);
$yzblog->assign('view',$con[0]['click']+1);
$yzblog->assign('content',$str);
$yzblog->assign('note',$note);
$yzblog->assign('css',$css);
$yzblog->display('articleadmin.html');
?>