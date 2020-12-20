<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <!--サインアップ、ログイン等　ヘッダーのhtmlを読み込む-->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
    <h1>商品一覧</h1>
    <!--配列で取得したエラーメッセージや結果を読み込む-->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <!--レイアウト-->
    <div class="card-deck">
      <div class="row">
      <!--配列で情報を取得-->
      <?php foreach($items as $item){ ?>
        <!--カラム６分割-->
        <div class="col-6 item">
          <!--カラムの幅-->
          <div class="card h-100 text-center">
            <!--カラムのヘッダー（商品名部分）-->
            <div class="card-header">
              <!--商品名-->
              <?php print($item['name']); ?>
            </div>
            <!--カラムのボディ（画像部分）-->
            <figure class="card-body">
              <!--商品画像-->
              <img class="card-img" src="<?php print(IMAGE_PATH . $item['image']); ?>">
              <!--画像の下に文字等を入れる-->
              <figcaption>
                <!--価格-->
                <?php print(number_format($item['price'])); ?>円
                <!--ストックの変更（ストックがあるならカートに入れることができる）-->
                <?php if($item['stock'] > 0){ ?>
                  <!--カートに追加のための情報をデータベースに送る（アップデート）-->
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <!--hiddenでitem_idを指定することで「変更ボタン」を押すと該当の商品をカートに入れることができる-->
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                  </form>
                <?php } else { ?>
                  <!--ストックが０なら（<0）-->
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  
</body>
</html>