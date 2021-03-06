<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

//データベースに接続
$db = get_db_connect();
//データベースからログイン情報（user_id）を取得
$user = get_login_user($db);
//ログインユーザーの購入履歴を全て取得
$histories = get_purchase_history($db, $user);
//購入履歴情報を取得できなければエラーメッセージを設定
if($histories === false){
  set_error('購入履歴情報を取得できませんでした。');
} 
include_once '../view/purchase_history_view.php';
