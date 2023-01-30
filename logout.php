<?php 
  require "admin/libs/functions.php";

  if($usersClass->isLogged()){
    if(isset($_SESSION["email"])){
      unset($_SESSION["email"]);
      unset($_SESSION["hash"]);

      header("Location: index");
      exit;
    }elseif(isset($_COOKIE["email"])){
      setcookie("email", $_COOKIE["email"], time() - 86400 * 30);
      setcookie("hash", $_COOKIE["hash"], time() - 86400 * 30);

      header("Location: index");
      exit;
    }else{
      echo "Hata var";
    }
  }else{
    header("Location: index");
    exit;
  }
?>