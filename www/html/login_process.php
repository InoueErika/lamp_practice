<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

if(is_logined() === true){
  redirect_to(HOME_URL);
}
//ユーザー名を設定
$name = get_post('name');
//パスワードを設定
$password = get_post('password');
//データベースに接続
$db = get_db_connect();

//データベースのユーザー情報と一致しなければエラーメッセージ
$user = login_as($db, $name, $password);
if( $user === false){
  set_error('ログインに失敗しました。');
  //ログイン画面へリダイレクト
  redirect_to(LOGIN_URL);
}
//管理者としてログインできたらメッセージを設定
set_message('ログインしました。');
if ($user['type'] === USER_TYPE_ADMIN){
  //管理画面へリダイレクト
  redirect_to(ADMIN_URL);
}
redirect_to(HOME_URL);