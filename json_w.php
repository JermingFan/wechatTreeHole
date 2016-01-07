<?php
require('inc/config_w.php');
require('inc/data_w.php');
$type=$_GET['type'];
$first=(int)$_GET['first'];
$eid=(int)$_GET['eid'];
if(!$first) $first=0;

$con=getdata($type,$first,"",$eid);
$c=count($con);
$str='[';
if($c){
  for($i=0;$i<$c;++$i){
  $con[$i]['title']= str_replace("\n",'\n',addslashes(htmlspecialchars( $con[$i]['title'],ENT_QUOTES)));
  $con[$i]['des']= str_replace("\n",'\n',addslashes(htmlspecialchars( $con[$i]['des'],ENT_QUOTES)));
    $str .= '{"id":"'.$con[$i]['id'].'","type":"'.$con[$i]['type'].'","lou":"'.$con[$i]['lou'].'","view":"'.$con[$i]['click'].'","comc":"'.$con[$i]['comc'].'","title":"'.$con[$i]['title'].'","timey":"'.date('Y年',$con[$i]['time']).'","timem":"'.date('m',$con[$i]['time']).'","timed":"'.date('d',$con[$i]['time']).'","week":"'.date('D',$con[$i]['time']).'","time":"'.date('H:i',$con[$i]['time']).'","des":"'.$con[$i]['des'].'","color":"'.$con[$i]['color'].'","ext":"'.($i+$first+1).'"},';
      
  }
  $str.= '"'.mysql_errno().'"]';
}else{
  $str.= '"'.mysql_errno().'"]';
}

echo $str;

?>