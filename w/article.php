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
  if($_GET['css_test']) $r = $_GET['css_test'];
  return $r;
}

$ua = $_SERVER['HTTP_USER_AGENT'];

if(!LOWCSS && key_match($ua,array(
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

$con=getdata($type,0,$id);

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

$a='div';$view='';
    $str .= 
      '<'.$a.' class="item" style="background:'.$comment[$i]['color'].';" href="article.php?id='.$comment[$i]['id'].'"><img class="point" src="../img/point.png" /><div class="num none">'.($i+$first+1).'</div><div class="view left">#'.$comment[$i]['lou'].'</div>'.$view.'<div class="time right"><span class="timed">'.date('d',$comment[$i]['time']).'</span>日<span class="timem">'.date('m',$comment[$i]['time']).'</span>月'.date('Y年 D H:i',$comment[$i]['time']).'</div><div class="des feeling">'.$comment[$i]['des'].'</div><h1 class="title">'.$comment[$i]['title'].'</h1></'.$a.'>';
    }
  }else{
    $note= '没有评论，来一条吧～';
}
$tttt = CLASS_1;
if($con[0]['class'] == 1001) $tttt = CLASS_2;
if($con[0]['class'] == 2001) $tttt = CLASS_3;

if(!ltrim($con[0]['author'])) $con[0]['title']="匿名";



$li_c = '<li>全部</li>';
if(CLASS_1 !== '') $li_o .= '<li>'.CLASS_1.'</li>';
if(CLASS_2 !== '') $li_o .= '<li>'.CLASS_2.'</li>';
if(CLASS_3 !== '') $li_o .= '<li>'.CLASS_3.'</li>';

$op_c = '';
if(CLASS_1 !== '') $op_c .= '<option value="1" selected="selected">'.CLASS_1.'</option>';
if(CLASS_2 !== '') $op_c .= '<option value="1001">'.CLASS_2.'</option>';
if(CLASS_3 !== '') $op_c .= '<option value="2001">'.ClASS_3.'</option>';

$yzblog->assign('title',SITE_NAME);
$yzblog->assign('copy_info',COPY_INFO);
$yzblog->assign('class_1',CLASS_1);
$yzblog->assign('class_2',CLASS_2);
$yzblog->assign('class_3',CLASS_3);
$yzblog->assign('op_c',$op_c);
$yzblog->assign('li_c',$li_c);

$yzblog->assign('tttt',$tttt);
$yzblog->assign('id',$con[0]['id']);
$yzblog->assign('t', htmlspecialchars($con[0]['title']));
$yzblog->assign('author', htmlspecialchars($con[0]['author']));
$yzblog->assign('ext', htmlspecialchars($con[0]['ext']));
$yzblog->assign('time',date('H:i:s Y年m月d日 D',$con[0]['time']));
$yzblog->assign('text',$text);
$yzblog->assign('color',$con[0]['color']);
$yzblog->assign('view',$con[0]['click']+1);
$yzblog->assign('content',$str);
$yzblog->assign('note',$note);
$yzblog->assign('css',$css);

$yzblog->display('article.html');
?>