<?php  
session_start();

//トークン作成 →セッションと非表示フィールドへ
include("makerandstr.php");  //外部参照
$_SESSION["himitsu"]= makeRandStr(20);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<!-- カレンダーライブラリ -->
<link rel="stylesheet" type="text/css" href="./datetimepicker/jquery.datetimepicker.css">
<link rel="stylesheet" href="style.css">
</head>

<body>
<h2>レストラン予約フォーム</h2>

<form action="kakunin.php" method="post">
<input type="hidden" name="himitsu" value="<?=$_SESSION['himitsu']?>">

<div>
<label>ご希望のコース</label>
<select name="course" required>
  <option value="">コースを選んでください</option>
  <option>ディナー/伊勢志摩の祝宴コース ¥18500</option>
  <option>ディナー/神楽坂の晩餐コース ¥15000</option>
  <option>ディナー/神楽坂の晩餐コース ¥13500</option>
</select>
</div>

<div>
<label>ご予約日時</label>
 <input type="text" name="yoyakuji" id="yyk_dhms"
 placeholder="年/月/日 時間" size="24" autocomplete="off" required>
</div>

<div>
<label>ご予約人数</label>
<select name="ninzu" required>
  <option value="">人数</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
</select> 名様
</div>

<div class="name">
<label>氏名</label>
  <input type="text" name="name" id="name" required><br>
<label>フリガナ</label>
  <input type="text" name="kana" id="name-furigana">
</div>

<div>
<label>電話番号</label>
<input type="tel" name="tel" id="" required>
</div>

<div>
<label>メールアドレス</label>
<input type="email" name="email" id="" required>
</div>

<div>
<label>郵便番号</label>
  <input type="text" name="zip" size="10" maxlength="8"
   onkeyup="AjaxZip3.zip2addr(this,'','addr','addr');" required>
 <!-- メソッドの引数が住所フィールドのname属性を示している '都道府県'+'住所' -->
<br>
<label>住所</label>
   <input type="text" name="addr" style="width:50%">
</div>

<div class="yobo">
<span role="label">ご要望</span>
<textarea name="yobo" id="" cols="50" rows="5"></textarea>
</div>

<div class="button">
<button type="submit">確認へ</button>
</div>
</form>

<script src="./datetimepicker/jquery.js"></script>
<script src="./datetimepicker/jquery.datetimepicker.js"></script>
<script src="jquery.autoKana.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script src="jquery.validate.js"></script>
<script src="messages_ja.js"></script>

<script>
$(function(){  //無名関数=呼び出し不要、読み込み時に即時実行
  //フォーム指定
  $('form').validate({
    rules:{
     email:{
       required:true,
       email:true
     },
     ninzu:{
       required:true,
       range:[1,4]
     },
     tel:{
       required:true,
       digits:true,  //整数以外はNG
       rangelength:[10,12]  //文字数範囲
     },
     zip:{
       required:true,
       digits:true,  //整数以外はNG
       rangelength:[7,7]  //文字数範囲
     }
    },
    messages:{
     email:{
      required:'メールアドレスを入力してください',
      email:'メールアドレスを正確に入力してください'
     },
     ninzu:{
      required:'人数を選択してください',
      range:'1以上、4以下の整数を選択してください'
     },
     tel:{
      required:'電話番号を入力してください',
      digits:'整数で入力してください',
      rangelength:'10～12桁で入力してください'
     },
     zip:{
      required:'郵便番号を入力してください',
      digits:'整数7桁で入力してください',
      rangelength:'7桁で入力してください'
     }
    },
  });
})

$("label").append("<em>(必須)</em>");

//カレンダー
$('#yyk_dhms').datetimepicker({
    lang:'ja',
    minDate : '-1970/01/01',
    maxDate : '+1970/01/31',  //1ヶ月後まで指定できる
    //timepicker:false
    allowTimes : ['17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00'],
    //step : 30
});

//自動かな入力
 $(function() {
    $.fn.autoKana('#name', '#name-furigana', {katakana:true});
 });
</script>

</body>
</html>
