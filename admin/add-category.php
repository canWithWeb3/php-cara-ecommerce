<?php 
  require "libs/functions.php";

  $name = "";
  $error = "";

  if(isset($_POST["addCategory"])){

    if(empty(trim($_POST["name"]))){
      $error = "Kategori adı boş geçilemez.";
    }else{
      $name = $othersClass->control_input($_POST["name"]);
    }

    if(empty($error)){
      if($categoriesClass->addCategory($name)){
        header("Location: categories");
        exit;
      }else{
        $error = "Kategori ekleme hatası";
      }
    }

  }

?>

<?php require "views/_admin-html-start.php"; ?>
<?php require "views/_sidebar-start.php"; ?>


<div>
  <div class="d-flex justify-content-between mb-4">
    <h1 class="h3">Kategori Ekle</h1>
  </div>
  
  <?php if(!empty($error)): ?>
    <div class="alert alert-warning">
      <p class="mb-0"><?php echo $error; ?></p>
    </div>
  <?php endif; ?>  

  <form method="POST">
    <div class="row mb-5">
      <!-- inputs -->
      <div class="col-md-6">
        <div class="form-group mb-3">
          <label for="name" class="form-label">Kategori Adı:</label>
          <input type="text" name="name" id="name" class="form-control" required
            value="<?php echo $name; ?>">
        </div>

      </div>
    </div>

    <div class="text-center">
      <button type="submit" name="addCategory" class="btn btn-success">Kategori Ekle</button>
    </div>
  </form>
</div>        


<?php require "views/_sidebar-finish.php"; ?>
<?php require "views/_admin-html-finish.php"; ?>
