<!DOCTYPE html>
<html lang="ja">
<head>
  <!--レイアウトを設定するため’templates/head.php’を読み込む-->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ログイン</title>
  <!--loginformの幅を設定-->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'login.css'); ?>">
</head>
<body>
  <!--サインアップ、ログイン等　ヘッダーのhtmlを読み込む-->
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <!--ウィンドウの幅に応じて変動させる-->
  <div class="container">
    <h1>ログイン</h1>
    <!--配列で取得したエラーメッセージや結果を読み込む-->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <!--ログインのセッション-->
    <form method="post" action="login_process.php" class="login_form mx-auto">
      <div class="form-group">
        <label for="name">名前: </label>
        <input type="text" name="name" id="name" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">パスワード: </label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <input type="submit" value="ログイン" class="btn btn-primary">
    </form>
  </div>
</body>
</html>