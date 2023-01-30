<?php 
  require "../admin/libs/functions.php";

  
  if(isset($_POST["loggedId"])){
    $loggedId = $othersClass->control_input($_POST["loggedId"]);

    $carts = $userCartsClass->getUserCartByUserId($loggedId);
    if($carts->rowCount() > 0){
      $count = 0;
      foreach($carts as $cart){
        $count += $cart["count"];
      }

      echo $count;
    }else{
      echo "0";
    }
  }else{
    echo "gelmedi";
  }
?>