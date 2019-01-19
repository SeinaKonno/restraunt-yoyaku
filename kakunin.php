<?php
/* XSS対策(トークン一致)
   →必須、バリデートチェック
    POST値を受け取ってサニタイズ
    →セッション変数へ代入
      →画面描画 →送信 */

session_start();
//一つでもtrueなら
// XSS対策(トークン一致)  必須、バリデートチェック

 // 一つでもtrueなら の比較式をチェックするならこうする
//var_dump(empty($_POST['himitsu']) , empty($_POST['yoyakuji']) , empty($_POST['name']) || empty($_POST['email']) , $_POST['himitsu']!= $_SESSION['himitsu']);
 if( empty($_POST['himitsu']) || empty($_POST['yoyakuji'])
    || empty($_POST['name']) || empty($_POST['email'])
    || $_POST['himitsu'] != $_SESSION['himitsu'] )
  exit("<p>必須事項がありません。フォームへ戻って入力してください。");  //ここで中断

// POST値を受け取ってサニタイズ
include("mojifilter.php");  //外部参照

//日時が正しいか確認
function cdk($datetime){
  return $datetime === date("Y/m/d H:i", strtotime($datetime));
}
if(!cdk($_POST['yoyakuji'])){
  exit("<p>日時が正しくありません。フォームへ戻って入れ直してください。"); //ここで中断
}

// →セッション変数へ代入
$_SESSION['course'] = h($_POST['course']);
$_SESSION['yoyakuji'] = h($_POST['yoyakuji']);
$_SESSION['ninzu'] = h($_POST['ninzu']);
$_SESSION['name'] = h($_POST['name']);
$_SESSION['kana'] = h($_POST['kana']);
$_SESSION['tel'] = h($_POST['tel']);
$_SESSION['email'] = h($_POST['email']);
$_SESSION['zip'] = h($_POST['zip']);
$_SESSION['addr'] = h($_POST['addr']);
$_SESSION['yobo'] = h($_POST['yobo']);

//必須じゃない項目の対応
if(!empty($_POST['kana'])){
  $_SESSION['kana']=h($_POST['kana']);
}else{
  $_SESSION['kana']="";  //null値にする訳にはいかない
}
if(!empty($_POST['yobo'])){
  $_SESSION['yobo']= nl2br(h($_POST['yobo']) );
}else{
  $_SESSION['yobo']="";
}
// →画面描画 →送信
?>
<h3>以下の内容で送信します</h3>
<dl>
  <dt>ご希望のコース</dt><dd><?=$_SESSION['course']?></dd>
  <dt>ご予約日時</dt><dd><?=$_SESSION['yoyakuji']?></dd>
  <dt>ご予約人数</dt><dd><?=$_SESSION['ninzu']?></dd>
  <dt>氏名</dt><dd><?=$_SESSION['name']?></dd>
  <dt>フリガナ</dt><dd><?=$_SESSION['kana']?></dd>
  <dt>電話番号</dt><dd><?=$_SESSION['tel']?></dd>
  <dt>メールアドレス</dt><dd><?=$_SESSION['email']?></dd>
  <dt>郵便番号</dt><dd><?=$_SESSION['zip']?></dd>
  <dt>住所</dt><dd><?=$_SESSION['addr']?></dd>
  <dt>ご要望</dt><dd><?=$_SESSION['yobo']?></dd>
</dl>

<button onclick="location.href='toroku.php'">送信する</button>
