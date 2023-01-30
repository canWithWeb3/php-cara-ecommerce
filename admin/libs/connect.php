<?php

  try {
      $db = new PDO("mysql:host=localhost; dbname=cara; charset=UTF8", "root", "");
      $example = "example";
  } catch(PDOException $e) {
      die($e->getMessage());
  }

?>