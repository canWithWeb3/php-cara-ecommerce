<?php 
  require "../admin/libs/functions.php";

  if(isset($_POST["id"])){
    $id = $othersClass->control_input($_POST["id"]);

    if($userCartsClass->deleteUserProduct($id)){
      echo "silindi";
    }else{
      echo "silinemdi";
    }
  }
?>