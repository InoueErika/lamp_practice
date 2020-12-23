<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ご購入ありがとうございました！</title>
  <!--購入商品表示のためのデザイン-->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
  <!--サインアップ、ログイン等　ヘッダーのhtmlを読み込む-->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>ご購入ありがとうございました！</h1>

  <div class="container">
    <!--配列で取得したエラーメッセージや結果を読み込む-->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <!--商品情報があれば情報を表示-->
    <?php if(count($carts) > 0){ ?>
      <table class="table table-bordered">
        <!--見出しに色をつける-->
        <thead class="thead-light">
          <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <!--配列で情報を取得-->
          <?php foreach($carts as $cart){ ?>
          <tr>
            <td><img src="<?php print(IMAGE_PATH . $cart['image']);?>" class="item_image"></td>
            <td><?php print h($cart['name']); ?></td>
            <td><?php print(number_format($cart['price'])); ?>円</td>
            <td>
                <?php print($cart['amount']); ?>個
            </td>
            <td><?php print(number_format($cart['price'] * $cart['amount'])); ?>円</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <p class="text-right">合計金額: <?php print number_format($total_price); ?>円</p>
    <?php } else { ?>
      <p>カートに商品はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>