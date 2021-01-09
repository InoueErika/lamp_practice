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
  <h1>購入履歴</h1>

  <div class="container">
    <!--配列で取得したエラーメッセージや結果を読み込む-->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <!--商品情報があれば情報を表示-->
    <?php if(count($histories) > 0){ ?>
      <table class="table table-bordered">
        <!--見出しに色をつける-->
        <thead class="thead-light">
          <tr>
            <th>購入履歴id</th>
            <th>購入時間</th>
            <th>購入金額</th>
          </tr>
        </thead>
        <tbody>
          <!--配列で情報を取得-->
          <?php foreach($histories as $history){ ?>
          <tr>
            <td><?php print($history['id']); ?></td>
            <td><?php print($history['create_datetime']); ?></td>
            <td><?php print($history['price']); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php foreach($total_history_price as $total_history){ ?>
        <p class="text-right">合計金額: <?php print($total_history['SUM(price)']); ?>円</p>
      <?php } ?>
    <?php } else { ?>
      <p>カートに商品はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>