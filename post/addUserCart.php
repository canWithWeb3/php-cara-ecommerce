<?php 
  require "../admin/libs/functions.php";

  if(isset($_POST["productId"])){
    $alertStatus = "";
    echo "";

    $productId = $othersClass->control_input($_POST["productId"]);
    $user = $usersClass->getLogged()->fetch(PDO::FETCH_ASSOC);
    
    $userCartProduct = $userCartsClass->getUserCartByUserIdAndProductId($user["id"], $productId);
    if($userCartProduct->rowCount()){
      $userCartProduct = $userCartProduct->fetch(PDO::FETCH_ASSOC);
      $newProductCount = $userCartProduct["count"] + 1;
      if($userCartsClass->editUserCartProductCount($userCartProduct["id"], $newProductCount)){
        echo "Sepetinize ". $newProductCount .". kez eklendi";
      }else{
        echo "Sepetinize eklenemedi";
      }
    }else{
      if($userCartsClass->addUserCart($user["id"],$productId)){
        echo "Sepetinize eklendi";
      }else{
        echo "Sepetinize eklenemedi";
      }
    }
  }else{
    echo "Sepetinize eklenemedi";
  }

  
?>