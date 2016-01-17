<?php
require_once('ubb.php');
#获取数据，返回数组
function getdata($type,$first,$id="",$eid='0'){

    $wb="";
    $id=(int)$id;
    $eid=(int)$eid;
    switch($type){
        case 'all':
            $sql="SELECT COUNT(*) AS count FROM ".WALL;
            if($id) $w=' WHERE id='.$id;
            $q= "SELECT * FROM ".WALL.$w." ORDER BY top,ctime desc,id desc limit ".$first.",10";
            break;
        case 'article':
            $sql="SELECT COUNT(*) AS count FROM ".WALL." WHERE class<1000";
            if($id) $w=' and id='.$id;
            $q= "SELECT * FROM ".WALL.$w." WHERE class<1000".$w." ORDER BY top,ctime desc,id desc limit ".$first.",10";
            break;
        case 'feeling':
            $sql="SELECT COUNT(*) AS count FROM ".WALL.' WHERE class>1000 and class<2000';
            if($id) $w=' and id='.$id;
            $q= "SELECT * FROM ".WALL.$w." WHERE class>1000 and class<2000".$w." ORDER BY top,ctime desc,id desc limit ".$first.",10";
            break;
        case 'message':
            $sql="SELECT COUNT(*) AS count FROM ".WALL.' WHERE class>2000 and class<3000';
            if($id) $w=' and id='.$id;
            $q= "SELECT * FROM ".WALL.$w." WHERE class>2000 and class<3000".$w." ORDER BY top,ctime desc,id desc limit ".$first.",10";
            break;
        case 'comment':
            $sql="SELECT COUNT(*) AS count FROM ".WALL_COMMENT.' WHERE eid='.$eid;
            $q= "SELECT * FROM ".WALL_COMMENT." WHERE eid=".$eid." ORDER BY id desc limit ".$first.",10";
            break;
        default:
            $sql="SELECT COUNT(*) AS count FROM ".WALL;
            if($id) $w=' WHERE id='.$id;
            $q= "SELECT * FROM ".WALL.$w." ORDER BY top,ctime desc,id desc limit ".$first.",10";
    }

    $error=-11;
    $link=mysql_connect(HOST.':'.PORT,USER,PASSWORD);
    if($link){
        mysql_select_db(DATABASE,$link);
        $r=mysql_query($q);

        $result=mysql_fetch_array(mysql_query($sql));
        $count=$result['count'];

        $rc = mysql_num_rows($r);
        $str='[';
        if($rc){
            for($i=0;$i<$rc;++$i){
                mysql_data_seek($r,$i);
                $data=mysql_fetch_array($r);






                if($type=='comment'){
                    $t='comment';
                    $data['title'] = badwordxx($data['author'],$badwords);
                    $data['des'] = badwordxx($data['content'],$badwords);
                }else{
                    #$data['title'] = $data['author'];
                    $data['title'] = badwordxx($data['author'],$badwords);
                    $data['content'] = badwordxx($data['content'],$badwords);
                    $data['des'] = badwordxx($data['des'],$badwords);

                    $commc=mysql_fetch_array(mysql_query("SELECT COUNT(*) AS com FROM ".WALL_COMMENT.' WHERE eid='.$data['id']));
                    $comc=$commc['com'];

                    if($data['class']>1000 && $data['class']<2000){
                        $t='feeling';
                        #$data['des']=$data['content'];
                        $data['des'] = ($data['content']);
                    }elseif($data['class']<1000){ $t='article';
// $data['des']=$data['content'];
                        $data['des'] = ($data['des']);
                        $data['des'] = ($data['content']); }elseif($data['class']<3000 && $data['class']<2000){ $t='message';
                        //$data['des']=$data['content'];
                    }
                }
                $ra[$i]=$data;
                $ra[$i]['type']=$t;
                $ra[$i]['lou']=(int)($count-$i-$first);
                $ra[$i]['comc']=(int)$comc;
            }
        }
    }
    return $ra;
}
?>