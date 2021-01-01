<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
//ログインのためセッション開始
session_start();
//ログインできなければログインページへ
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
//トークンのチェック
$token = get_post('token');
if (is_valid_csrf_token($token) === false){
  set_error('ステータスの変更に失敗しました。');
  //管理画面へリダイレクト
  redirect_to(ADMIN_URL);
}
//データベースに接続
$db = get_db_connect();
//データベースからログイン情報（user_id）を取得
$user = get_login_user($db);
//管理者のログイン情報が間違っていればログインページへ
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
//postでitem_idを取得
$item_id = get_post('item_id');
//postで公開・非公開情報を取得
$changes_to = get_post('changes_to');
//公開・非公開をそれぞれ設定した場合
if($changes_to === 'open'){
  //データベースの情報をアップデート
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  //メッセージの設定
  set_message('ステータスを変更しました。');
}else if($changes_to === 'close'){
  //データベースの情報をアップデート
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  //メッセージの設定
  set_message('ステータスを変更しました。');
}else {
  //できなかったらエラー文
  set_error('不正なリクエストです。');
}

//管理ページへリダイレクト
redirect_to(ADMIN_URL);