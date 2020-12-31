<?php

function dd($var){
  var_dump($var);
  exit();
}
//ログイン成功したら飛ぶ場所
function redirect_to($url){
  header('Location: ' . $url);
  exit;
}
//名前（ユーザー名または商品名）を定義（GET）getはURLのパラメーターを取り出す
function get_get($name){
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}
//名前（ユーザー名または商品名）を定義（POST）formでpostとして送られた情報
function get_post($name){
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}
//アップロードされた画像を取得する（formから送信されたファイル）
function get_file($name){
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}
//既に設定している内容を’取得する’「get」
function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}
//$name（ユーザー名、商品名に拘らず）にあたるのもを’設定する’「set」
function set_session($name, $value){
  $_SESSION[$name] = $value;
}
//ログインした際のエラー
function set_error($error){
  $_SESSION['__errors'][] = $error;
}
//エラーの初期化と定義
function get_errors(){
  $errors = get_session('__errors');
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}
//エラーがあった場合の変数（「！＝＝」エラーが０ではなかったら）
function has_error(){
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}
//処理完了した場合のメッセージを設定する
function set_message($message){
  $_SESSION['__messages'][] = $message;
}
//処理完了した場合のメッセージを取得する（表示のする）
function get_messages(){
  $messages = get_session('__messages');
  if($messages === ''){
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}
//user_idが空じゃなかったら（ログインできたら）
function is_logined(){
  return get_session('user_id') !== '';
}
//アップロードされたファイル名を取得する（ランダムに決められたファイル名を取得する）
function get_upload_filename($file){
  if(is_valid_upload_image($file) === false){
    return '';
  }
  $mimetype = exif_imagetype($file['tmp_name']);
  $ext = PERMITTED_IMAGE_TYPES[$mimetype];
  return get_random_string() . '.' . $ext;
}
//文字の長さの設定？
function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}
//アップロードされたファイルがサーバー上で保存されている時のファイル名
function save_image($image, $filename){
  return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}
//画像の削除
function delete_image($filename){
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
    return true;
  }
  return false;
  
}



function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

function is_positive_integer($string){
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}


function is_valid_upload_image($image){
  if(is_uploaded_file($image['tmp_name']) === false){
    set_error('ファイル形式が不正です。');
    return false;
  }
  $mimetype = exif_imagetype($image['tmp_name']);
  if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}
//h関数（特殊文字を処理させない）
function h($str) {
 
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// トークンの生成
function get_csrf_token(){
  // get_random_string()はユーザー定義関数。
  $token = get_random_string(30);
  // set_session()はユーザー定義関数。
  set_session('csrf_token', $token);
  return $token;
}

// トークンのチェック
function is_valid_csrf_token($token){
  if($token === '') {
    return false;
  }
  // get_session()はユーザー定義関数
  return $token === get_session('csrf_token');
}

