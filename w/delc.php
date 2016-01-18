<html>
<head>
    <meta charset=utf-8" />
    <title>操作结果</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
<body>
<?php
require('../inc/config_w.php');

$id=(int)$_GET['id'];

$link=mysql_connect(HOST.':'.PORT,USER,PASSWORD);
if($link){
    mysql_select_db(DATABASE,$link);
    if(mysql_query('delete from '.WALL_COMMENT.' where id='.$id)) echo '操作成功';
    else echo '操作失败！';
}else echo '链接数据库失败！';
?>
</body>
</html>