<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
//ログインのためのセッション
if(is_logined() === true){
  redirect_to(HOME_URL);
}
//トークンを生成する処理
$token = get_csrf_token();

include_once VIEW_PATH . 'login_view.php';