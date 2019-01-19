<?php
session_start();

if( empty($_SESSION['name']) ){
  echo "入力情報がありません。<a href='yoyaku.php'>予約ページ</a>から
       必須事項を入力して送信してください。";
  exit();
}
include("connect.php");

try{
  $dbh->beginTransaction();  //トランザクション開始

/* →DB登録(cst , yyk)
   ロジック
   1 cstへ先に入れる
   2 自動連番で生成したkidを取得してyykに入れる
      →次のA_Iの番号を取得する関数を使う
   3 cstに入ってyykに入らない事態を避ける方法(トランザクション) 
   
   1.SQL文 cstにインサート */
    $sql ='INSERT INTO cst(name,kana,zip,addr,email,tel)
       VALUES ( ?,?,?,?,?,? )';
//     プリペアドステートメント
       $sth= $dbh->prepare($sql);
//     バインド機構
       $i=0;
       $sth->bindValue(++$i,$_SESSION['name'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$_SESSION['kana'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$_SESSION['zip'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$_SESSION['addr'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$_SESSION['email'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$_SESSION['tel'],PDO::PARAM_STR);
//       エクスキュート
var_dump($sql,$_SESSION['name'],$_SESSION['kana'],$_SESSION['zip'],
          $_SESSION['naaddrme'],$_SESSION['email'],$_SESSION['tel']);
          
        $sth->execute();
//         最後のオートインクリメントを取得
           $kid = $dbh->lastInsertId('kid');

// 2.SQL文 yykにインサート
//    以下同じ
    $sql ='INSERT INTO yyk(course,yoyakuji,ninzu,yobo,kid)
      VALUES ( ?,?,?,?,? )';
       $sth= $dbh->prepare($sql);
       $i=0;
       $sth->bindValue(++$i,$_SESSION['course'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$_SESSION['yoyakuji'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$_SESSION['ninzu'],PDO::PARAM_INT);
       $sth->bindValue(++$i,$_SESSION['yobo'],PDO::PARAM_STR);
       $sth->bindValue(++$i,$kid,PDO::PARAM_INT);
       $sth->execute();

$dbh->commit();  //コミット すべて実行
//  → "ありがとう"の画面で終わる
//    →メール送信(予約者、管理者)

  echo "ご予約ありがとうございました。";

}catch (Exception $e){
  $dbh->rollBack();  //ロールバック 全てなかったことに
  echo "失敗しました。" . $e->getMessage();
}

// →セッション削除
$_SESSION = array();
session_destroy();