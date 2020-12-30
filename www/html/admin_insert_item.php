<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
//トークンのチェック
$token = get_post('token');
if (is_valid_csrf_token($token) === false){
  set_error('ログインに失敗しました。');
  //ログイン画面へリダイレクト
  redirect_to(LOGIN_URL);
}
//データベースに接続
$db = get_db_connect();
//データベースからログイン情報（user_id）を取得
$user = get_login_user($db);
//管理者情報が間違っていたらログインページへ
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
//以下の情報をインサートするためfromから取得
$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');

$image = get_file('image');
//商品を登録できたら（データベースにインサートできたら）メッセージを設定
if(regist_item($db, $name, $price, $stock, $status, $image)){
  set_message('商品を登録しました。');
}else {
  set_error('商品の登録に失敗しました。');
}


redirect_to(ADMIN_URL);