<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

//トークンを生成する処理
$token = get_csrf_token();
//データベースに接続
$db = get_db_connect();
//データベースからログイン情報（user_id）を取得
$user = get_login_user($db);

if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
//データベースから取得した全ての商品情報
$items = get_all_items($db);
include_once VIEW_PATH . '/admin_view.php';
