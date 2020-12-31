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
  //管理画面へリダイレクト
  redirect_to(ADMIN_URL);
}
//データベースに接続
$db = get_db_connect();
//データベースからログイン情報（user_id）を取得
$user = get_login_user($db);
//管理者情報が間違っていたらログインページへ
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
//item_idをpostで取得
$item_id = get_post('item_id');

//しょうひんの削除をしたらメッセージを設定
if(destroy_item($db, $item_id) === true){
  set_message('商品を削除しました。');
} else {
  set_error('商品削除に失敗しました。');
}



redirect_to(ADMIN_URL);