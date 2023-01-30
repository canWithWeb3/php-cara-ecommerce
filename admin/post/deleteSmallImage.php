<?php 
  require "../libs/functions.php";

  if($usersClass->isLogged() && $usersClass->isAdmin()){
    $id = $othersClass->control_input($_POST["id"]);
    if($filesClass->deleteSmallImageById($id)){
      return true;
    }else{
      return false;
    }
  }else{
    return false;
  }
?>