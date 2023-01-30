<?php 
  require "libs/functions.php";

  if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: categories");
    exit;
  }else{
    $_GET["id"] = $othersClass->control_input($_GET["id"]);

    $category = $categoriesClass->getCategoryById($_GET["id"])->fetch(PDO::FETCH_ASSOC);
    if($category["id"] == null){
      header("Location: categories");
      exit;
    }
    
  }

  $id = $category["id"];
  $name = $category["name"];
  $error = "";

  if(isset($_POST["editCategory"])){

    if(empty(trim($_POST["name"]))){
      $error = "Kategori adı boş geçilemez.";
    }else{
      $name = $othersClass->control_input($_POST["name"]);
    }

    if(empty($error)){
      if($categoriesClass->editCategoryById($id,$name)){
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
    <h1 class="h4">Kategori Düzenle</h1>
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
      <button type="submit" name="editCategory" class="btn btn-success">Kategori Düzenle</button>
    </div>
  </form>
</div>        


<?php require "views/_sidebar-finish.php"; ?>
<?php require "views/_admin-html-finish.php"; ?>
