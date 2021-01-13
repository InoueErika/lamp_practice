<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴画面</title>
  <!--購入履歴表示のためのデザイン-->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
  <!--サインアップ、ログイン等　ヘッダーのhtmlを読み込む-->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入詳細</h1>

  <div class="container">
    <!--配列で取得したエラーメッセージや結果を読み込む-->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <!--商品情報があれば情報を表示-->
      <ul>
        <li>注文番号：<?php print($history['id']); ?></li>
        <li>購入日時：<?php print($history['create_datetime']); ?></li>
        <li>合計金額：<?php print($history['SUM(Purchase_details.amount * Purchase_details.price)']); ?>円</li>
      </ul>
    <?php if(count($details) > 0){ ?>
      <table class="table table-bordered">
        <!--見出しに色をつける-->
        <thead class="thead-light">
          <tr>
            <th>商品名</th>
            <th>購入時の商品価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <!--配列で情報を取得-->
          <?php foreach($details as $detail){ ?>
          <tr>
            <td><?php print h($detail['name']); ?></td>
            <td><?php print($detail['price']); ?></td>
            <td><?php print($detail['amount']); ?></td>
            <td><?php print($detail['Purchase_details.amount * Purchase_details.price']); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>カートに商品はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>