<?php 
  require "libs/functions.php";

  $name = $color = "";
  $error = "";

  if(isset($_POST["addColor"])){

    if(empty(trim($_POST["color"]))){
      $error = "Renk boş geçilemez.";
    }else{
      $color = $othersClass->control_input($_POST["color"]);
    }

    if(empty(trim($_POST["name"]))){
      $error = "Renk adı boş geçilemez.";
    }else{
      $name = $othersClass->control_input($_POST["name"]);
    }

    if(empty($error)){
      if($colorsClass->addColor($color,$name)){
        header("Location: colors");
        exit;
      }else{
        $error = "Renk ekleme hatası";
      }
    }

  }

?>

<?php require "views/_admin-html-start.php"; ?>
<?php require "views/_sidebar-start.php"; ?>


<div>
  <div class="d-flex justify-content-between mb-4">
    <h1 class="h3">Renk Ekle</h1>
  </div>
  
  <?php if(!empty($error)): ?>
    <div class="alert alert-warning">
      <p class="mb-0"><?php echo $error; ?></p>
    </div>
  <?php endif; ?>  

  <form method="POST">
    <div class="row mb-5">
      <!-- inputs -->
      <div class="col-md-12">
        <div class="form-group mb-3">
          <label for="color" class="form-label">Renk:</label>
          <input style="height: 60px;" type="color" name="color" id="color" class="form-control" required
            value="<?php echo $color; ?>">
        </div>

        <div class="form-group mb-3">
          <label for="name" class="form-label">Renk Adı:</label>
          <input type="text" name="name" id="name" class="form-control" required
            value="<?php echo $name; ?>">
        </div>

      </div>
    </div>

    <div class="text-center">
      <button type="submit" name="addColor" class="btn btn-success">Renk Ekle</button>
    </div>
  </form>
</div>        


<?php require "views/_sidebar-finish.php"; ?>
<?php require "views/_admin-html-finish.php"; ?>
