<?php 
if ($dir = opendir("./")) {  // ディレクトリが オープンできない場合、opendir() は FALSE
    while (($file = readdir($dir)) !== false) {
        if ( !preg_match('/(.htaccess|.cgi|.sql|.css)/', $file) && '.'!=$file 
        && '..'!=$file || preg_match('/(.php)/', $file)) {
            $farray[]= "<li><a href='$file'> $file </a>";
        }
    } 
    closedir($dir);
        natcasesort($farray)    ;
     
?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>ファイル一覧</title>
</head>
<body><ol>
    <?php  foreach ($farray as $value) {
       // echo mb_convert_encoding( $value, 'utf-8','Shift_jis') ;
    				echo $value;
        }
}
?>
</ol>
</body>
</html>