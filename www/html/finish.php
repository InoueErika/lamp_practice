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
//カート内の全商品を全て取得（購入のため）
$carts = get_user_carts($db, $user['user_id']);
//購入できなかった場合エラーメッセージを設定
if(purchase_carts($db, $carts,$user['user_id']) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} 
//カート内全商品の合計金額
$total_price = sum_carts($carts);

include_once '../view/finish_view.php';