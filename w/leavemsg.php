<?php
include '../inc/config_w.php';

$author=$_POST['nickname'];
$content=$_POST['msgcontent'];
$color=$_POST['color'];
$id=(int)$_POST['id'];

if(!get_magic_quotes_gpc()){
$author= addslashes($_POST['nickname']);
$content= addslashes($_POST['msgcontent']);
$color= addslashes($_POST['color']);
}

if(ltrim($content)){
$error=-11;
$link=mysql_connect(HOST.':'.PORT,USER,PASSWORD);
if($link){
  mysql_select_db(DATABASE,$link);
  
  mysql_query("INSERT INTO ".WALL_COMMENT." SET author='".$author."',content='".$content."',color='".$color."',eid=".$id.",time=".time().";");
  mysql_query('UPDATE '.WALL.' SET ctime='.time().' where id='.$id);
  $error= mysql_errno();

}
}else $error=-1;

echo $error;
?>