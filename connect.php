<?php

$host = 'localhost';
  $dbname = 'yoyaku';
  $user = '****';
  $pswd = '****'; //接続情報は変数にいれましょう

try{  //つながったら有効にする
  $dsn="mysql:dbname=$dbname;host=$host;charset=utf8";
  $dbh=new PDO($dsn,$user,$pswd);
  // PDOのエラーモードを ONにする
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //エミュレートOFF,構文☑と実行を分離する(必須)
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

}catch(PDOException $e){
 die('接続エラー: ' . $e->getCode());
}
