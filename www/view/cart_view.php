<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>カート</title>
  <!--画像の大きさと個数変更の入力欄の大きさ-->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
  <!--サインアップ、ログイン等　ヘッダーのhtmlを読み込む-->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>カート</h1>
  <div class="container">
    <!--配列で取得したエラーメッセージや結果を読み込む-->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <!--商品情報があれば情報を表示-->
    <?php if(count($carts) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>購入数</th>
            <th>小計</th>
            <th>操作</th>
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
              <!--購入数の情報をデータベースに送る（アップデート）-->
              <form method="post" action="cart_change_amount.php">
                <input type="text" name="amount" value="<?php print($cart['amount']); ?>">
                個
                <input type="submit" value="変更" class="btn btn-secondary">
                <!--hiddenでcart_idを指定することで「変更ボタン」を押すと該当の商品の購入数を変更することができる-->
                <input type="hidden" name="cart_id" value="<?php print($cart['cart_id']); ?>">
              </form>
            </td>
            <!--金額と購入数を掛けて小計を出す-->
            <td><?php print(number_format($cart['price'] * $cart['amount'])); ?>円</td>
            <td>
              <!--商品情報削除のための情報をデータベースに送る（デリート）-->
              <form method="post" action="cart_delete_cart.php">
                <input type="submit" value="削除" class="btn btn-danger delete">
                <!--hiddenでcart_idを指定することで「削除ボタン」を押すと該当の商品をカートから削除ことができる-->
                <input type="hidden" name="cart_id" value="<?php print($cart['cart_id']); ?>">
              </form>

            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <!--合計金額（データベースからセレクト）-->
      <p class="text-right">合計金額: <?php print number_format($total_price); ?>円</p>
      <!--購入情報をデータベースに送る。ストックの変更（アップデート）-->
      <form method="post" action="finish.php">
        <input class="btn btn-block btn-primary" type="submit" value="購入する">
      </form>
    <?php } else { ?>
      <p>カートに商品はありません。</p>
    <?php } ?> 
  </div>
  <script>
    //「削除ボタン」を押すとコメントが出てくる
    $('.delete').on('click', () => confirm('本当に削除しますか？'))
  </script>
</body>
</html>