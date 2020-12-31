<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

if(is_logined() === true){
  redirect_to(HOME_URL);
}
//ユーザー名の設定
$name = get_post('name');
//パスワードの設定
$password = get_post('password');
//確認用パスワードを設定
$password_confirmation = get_post('password_confirmation');
//トークンのチェック
$token = get_post('token');
if (is_valid_csrf_token($token) === false){
  set_error('ログインに失敗しました。');
  //サインアップ画面へリダイレクト
  redirect_to(SIGNUP_URL);
}
//データベースに接続
$db = get_db_connect();
//ユーザー情報を登録（インサート）
try{
  $result = regist_user($db, $name, $password, $password_confirmation);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    //失敗したらサインアップページへ
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}
//成功したらメッセージの設定
set_message('ユーザー登録が完了しました。');
login_as($db, $name, $password);
//ログインページへ
redirect_to(HOME_URL);