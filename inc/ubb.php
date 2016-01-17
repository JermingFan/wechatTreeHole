<?php
function badwordxx($str,$badwords){

    $bstr = file_get_contents(dirname(__FILE__).'/badwords.php');
    $badwords = array_diff(explode("\n",$bstr),array(null));

    $sta = '*';//敏感词替换成什么
    $badword1 = array_combine($badwords,array_fill(0,count($badwords),$sta));
    return strtr($str, $badword1);
}

function straddubb($str){
    /*$bstr = file_get_contents('badwords.php');
    $badwords = array_diff(explode("\n",$bstr),array(null));*/

    $str = badwordxx($str,$badwords);

    $str=str_replace('[p]','<p>',$str);
    $str=str_replace('[/p]','</p>',$str);

    $str=str_replace('[b]','<b>',$str);
    $str=str_replace('[/b]','</b>',$str);

    $str=str_replace('[hr]','<hr />',$str);

    $str=str_replace('  ','&nbsp;&nbsp;',$str);

    $str=preg_replace('|\[img=(.*?)\]|ism','<img src="$1" />',$str);

    $str=preg_replace('|\[a=(.*?)\](.*?)\[/a\]|ism','<a href="$1">$2</a>',$str);
    $str=preg_replace('|\[url=(.*?)\]|ism','<a href="$1">$1</a>',$str);


    $str=str_replace('(*;)','[',$str);
    $str=str_replace('(#;)',']',$str);
    return $str;
}
