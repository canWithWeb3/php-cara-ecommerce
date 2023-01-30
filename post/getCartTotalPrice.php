<?php 
  require "../admin/libs/functions.php";

  $logged = $usersClass->getLogged()->fetch(PDO::FETCH_ASSOC); 
  $carts = $userCartsClass->getUserCartByUserId($logged["id"]); 
  $totalPrice = 0;
  foreach($carts as $cart){
    $p = $productsClass->getProductById($cart["productId"])->fetch(PDO::FETCH_ASSOC);
    $totalPrice += $cart["count"] * $p["newPrice"];
  }

  echo "$".$totalPrice;
?>