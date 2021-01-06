<?php 
//formで送られた情報を読み取る
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
//どのユーザーが何の商品をカートに入れたのか（cartテーブルはitem.idとuser.idをインサートしている）
function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
  ";
  $params = [$user_id];
  return fetch_all_query($db, $sql, $params);
}
//どのユーザーが何の商品を購入したのか
function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
    AND
      items.item_id = ?
  ";
  //以下の方法はparamsを使わない
  return fetch_query($db, $sql, [$user_id, $item_id]);

}
//カートに追加
function add_cart($db, $user_id, $item_id ) {
  $cart = get_user_cart($db, $user_id, $item_id);
  //カートに中身が入っていなければuser_idとitem_idを新規で取得
  if($cart === false){
    return insert_cart($db, $user_id, $item_id);
  }
  //カートに中が入っていればしょうひんの合計数を１つ増やす
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}
//user_idをインサートすることでどのユーザーか特定、item_idをインサートすることで商品情報を特定
function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES(?, ?, ?)
  ";
  $params = [$item_id, $user_id, $amount];
  return execute_query($db, $sql, $params);
}
//カートの中の商品数をアップデート
//Lmit1は一件だけという意味
function update_cart_amount($db, $cart_id, $amount){
  $sql = "
    UPDATE
      carts
    SET
      amount = ?
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  $params = [$amount, $cart_id];
  return execute_query($db, $sql, $params);
}
//カートから特定の商品をデリート
function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  $params = [$cart_id];
  return execute_query($db, $sql, $params);
}

function purchase_carts($db, $carts, $user_id){
  if(validate_cart_purchase($carts) === false){
    return false;
  }
  //ここからトランザクション
  $db->beginTransaction();
  //purchase_historyにインサート
  $sql = "
    INSERT INTO 
      Purchase_history
      (user_id)
    VALUES
      (?)";
  $params = [$user_id];
  if(execute_query($db, $sql, $params) === false){
    return false;
  }
  $Purchase_history = $db->lastInsertId('id');//idをとってくる

  //商品を購入後、ストック数を減らす
  foreach($carts as $cart){
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){
      set_error($cart['name'] . 'の購入に失敗しました。');
    }
    //purchase_detailにインサートする
    $sql = "
    INSERT INTO 
    Purchase_details
      (item_id,Purchase_history,price,amount)
    VALUES
      (?,?,?,?)";
    $params = [$cart['item_id'],$Purchase_history,$cart['price'],$cart['amount']];
    if (execute_query($db, $sql, $params) === false){
      return false;
    }
  }
  //エラーだったらロールバック
  if(has_error() === true){
    $db->rollback();
    return false;
  }
  //ここまでトランザクション
  //特定のユーザーの商品を消去する
  delete_user_carts($db, $carts[0]['user_id']);
  //エラーがなければコミット
  $db->commit();
  return true;
  
}
//ユーザー情報を消去する（次回ログインして商品をカートに入れた時、カート内に前回購入した商品を残さないようにするため）
function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = ?
  ";
  $params = [$user_id];
  execute_query($db, $sql, $params);
}

//カートの中の合計金額
function sum_carts($carts){
  $total_price = 0;
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}

function validate_cart_purchase($carts){
  //商品が選択されていなければエラー
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  //非公開の商品ならエラー
  foreach($carts as $cart){
    if(is_open($cart) === false){
      set_error($cart['name'] . 'は現在購入できません。');
    }
    //ストックから商品数を引いた数が0より小さければ
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  //エラーがあった場合はtrue
  if(has_error() === true){
    return false;
  }
  return true;
}

