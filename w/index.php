<?php
require('../inc/config_w.php');
require('../inc/setsmarty.php');
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
$first=(int)$_GET['first'];
if(!$first) $first=0;

switch($type){
  case 'article':
    $tp=1;
    break;
  case 'feeling':
    $tp=2;
    break;
  case 'message':
    $tp=3;
    break;
  default:
    $tp=0;
}

$con=getdata($type,$first);

$c=count($con);
if($c){

  for($i=0;$i<$c;++$i){
    $con[$i]['title']= htmlspecialchars( $con[$i]['title'],ENT_QUOTES);
    $con[$i]['des']= htmlspecialchars( $con[$i]['des'],ENT_QUOTES);
    $a='a';
    $view='<div class="view left"> 点:'.(int)$con[$i]['click'].' 评:'.(int)$con[$i]['comc'].'</div>';
    if($con[$i]['type']=='message'){ $a='div';$view='';}
    $str .= '<a class="item" style="background:'.$con[$i]['color'].';" href="article.php?id='.$con[$i]['id'].'"><img class="point" src="../img/point.png" /><div class="num none">'.($i+$first+1).'</div><div class="view left">#'.$con[$i]['lou'].'</div>'.$view.'<div class="time right"><span class="timed">'.date('d',$con[$i]['time']).'</span>日<span class="timem">'.date('m',$con[$i]['time']).'</span>月'.date('Y年 D H:i',$con[$i]['time']).'</div><div class="des feeling">'.$con[$i]['des'].'</div><h1 class="title" style="text-align:right">'.$con[$i]['title'].'</h1></a>';
  }
}else{
  $note= '没有内容！';
}

$li_c = '<li>全部</li>';
if(CLASS_1 !== '') $li_c .= '<li>'.CLASS_1.'</li>';
if(CLASS_2 !== '') $li_c .= '<li>'.CLASS_2.'</li>';
if(CLASS_3 !== '') $li_c .= '<li>'.CLASS_3.'</li>';

$op_c = '';
if(CLASS_1 !== '') $op_c .= '<option value="1" selected="selected">'.CLASS_1.'</option>';
if(CLASS_2 !== '') $op_c .= '<option value="1001">'.CLASS_2.'</option>';
if(CLASS_3 !== '') $op_c .= '<option value="2001">'.CLASS_3.'</option>';

$yzblog->assign('title',SITE_NAME);
$yzblog->assign('site_name',SITE_NAME);
$yzblog->assign('copy_info',COPY_INFO);
$yzblog->assign('class_1',CLASS_1);
$yzblog->assign('class_2',CLASS_2);
$yzblog->assign('class_3',CLASS_3);
$yzblog->assign('op_c',$op_c);
$yzblog->assign('li_c',$li_c);

$yzblog->assign('typeindex',$tp);
$yzblog->assign('type',$type);
$yzblog->assign('note',$note);
$yzblog->assign('content',$str);
$yzblog->assign('css',$css);

$yzblog->display('index.html');