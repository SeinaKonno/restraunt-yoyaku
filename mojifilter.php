<?php

//POST値を受け取ってサニタイズ
function h($a){
    //戻り値を受け取る必要がある
    $a = htmlspecialchars($a ,ENT_QUOTES,"UTF-8");
    //有害文字列 \バックスラッシュ、ハイフンの置換  
    $a = str_replace("\\","¥",$a);  
    $a = str_replace("-","－",$a);  
    return $a;
}
