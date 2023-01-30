<?php 
  require "libs/functions.php";

  $image = $brand = $name = $description = $oldPrice = $newPrice = $gender = "";
  $selectedCategories = $selectedColors = [];
  $error = "";

  if(isset($_POST["addProduct"])){
    // validation image
    if (empty($_FILES["image"]["name"])) {
      if(empty($_POST["oldImage"])){
        $error = "dosya seçiniz";
      }else{
        $image = $_POST["oldImage"];
      }
    } else {
        $result = $othersClass->saveImage($_FILES["image"]);

        if($result["isSuccess"] == 0) {
            $error = $result["message"];
        } else {
            $image = $result["image"];
        }
    }

    if(empty(trim($_POST["brand"]))){
      $error = "Ürün marka boş geçilemez.";
    }else{
      $brand = $othersClass->control_input($_POST["brand"]);
    }

    if(empty(trim($_POST["name"]))){
      $error = "Ürün adı boş geçilemez.";
    }else{
      $name = $othersClass->control_input($_POST["name"]);
    }

    $description = $othersClass->control_input($_POST["description"]);

    if(!empty(trim($_POST["oldPrice"]))){
      if(!is_numeric($_POST["oldPrice"]) || $_POST["oldPrice"] < 0){
        $error = "Eski Fiyat sayı olmalıdır.";
      }else{
        $oldPrice = $othersClass->control_input($_POST["oldPrice"]);
      }
    }

    if(empty(trim($_POST["newPrice"]))){
      $error = "Yeni Fiyat boş geçilemez.";
    }elseif(!is_numeric($_POST["newPrice"])){
      $error = "Yeni Fiyat sayı olmalıdır.";
    }elseif(!empty($oldPrice) && ($oldPrice <= $_POST["newPrice"])){
      $error = "Yeni fiyat eski fiyattan büyük olamaz.";
    }else{
      $newPrice = $othersClass->control_input($_POST["newPrice"]);
    }

    if(empty($_POST["categories"])){
      $error = "Kategori seçilmedi.";
    }elseif(count($_POST["categories"]) > 3){
      $error = "Kategori 3'den fazla seçilemez.";
    }else{
      foreach($_POST["categories"] as $postCategory){
        $postCategory = $othersClass->control_input($postCategory);
        array_push($selectedCategories, $postCategory);
      }
    }

    if(empty($_POST["gender"])){
      $error = "Cinsiyet seçilmedi.";
    }else{
      $gender = $othersClass->control_input($_POST["gender"]);
    }

    

    if(empty($_POST["colors"])){
      $error = "Renk seçilmedi.";
    }else{
      foreach($_POST["colors"] as $postColor){
        $postColor = $othersClass->control_input($postColor);
        array_push($selectedColors, $postColor);
      }
    }

    if(empty($error)){
      $slug = $othersClass->stringToSlug($name);
      $getProductBySlug = $productsClass->getProductBySlug($slug);
      if($getProductBySlug->rowCount() > 0){
        for($i = 2; $i < 999; $i++){
          $newSlug = $slug."-".$i;
          $getProductBySlug = $productsClass->getProductBySlug($newSlug);
          if($getProductBySlug->rowCount() == 0){
            $slug = $newSlug;
            break;
          }
        }
      }

      if($productsClass->addProduct($image,$brand,$name,$description,$oldPrice,$newPrice,$gender,$slug)){
        $lastProduct = $productsClass->getLastProduct()->fetch(PDO::FETCH_ASSOC);

        if($productCategoriesClass->addProductCategories($lastProduct["id"], $selectedCategories)){
          if($productColorsClass->addProductColors($lastProduct["id"], $selectedColors)){
            $smallImages = $_FILES["smallImages"]["name"];
            foreach($smallImages as $key => $file){
                if(!empty($_FILES["smallImages"]["name"][$key])){
                  $fileName = $_FILES["smallImages"]["name"][$key];
                  $dosyaAdi_Arr = explode(".", $fileName);
                  $dosyaAdi_uzantisiz = $dosyaAdi_Arr[0];
                  $dosyaUzantisi = $dosyaAdi_Arr[1];

                  $dosyaUzantilari = array("jpg","jpeg","png","gif","docx","doc","xls","xlsx");
                  if(!in_array($dosyaUzantisi, $dosyaUzantilari)){
                    $files_err = "Kabul edilen dosya uzantıları: (pdf,docx,doc,xls,xlsx,jpg,jpeg,png,gif)";
                  }

                  if(empty($files_err)){
                    $uploadFolder = "./image/";
          
                    $yeniDosyaAdi = md5(time().$dosyaAdi_uzantisiz).'.'.$dosyaUzantisi;
                    $dest_path = $uploadFolder.$yeniDosyaAdi;
          
                    $tmp_name = $_FILES["smallImages"]["tmp_name"][$key];
                    move_uploaded_file($tmp_name, $dest_path);

                    if($filesClass->addSmallImagesToProduct($lastProduct["id"],$yeniDosyaAdi)){ 

                    }else{
                      $files_error = "Dosya yüklenemedi"; 
                    }
                  }
                }

            }

            header("Location: products");
            exit;
          }else{
            $error = "Ürün ve kategorileri eklendi fakat renkler eklenemedi.";
          }
        }else{
          $error = "Ürün eklendi fakat kategorileri eklenemedi.";
        }
      }else{
        $error = "Ürün ekleme hatası";
      }
    }

  }

?>

<?php require "views/_admin-html-start.php"; ?>
<?php require "views/_sidebar-start.php"; ?>


<div>
  <div class="d-flex justify-content-between mb-4">
    <h1 class="h3">Ürün Ekle</h1>
  </div>
  
  <?php if(!empty($error)): ?>
    <div class="alert alert-warning">
      <p class="mb-0"><?php echo $error; ?></p>
    </div>
  <?php endif; ?>  

  <form method="POST" enctype="multipart/form-data">
    <div class="row mb-5">
      <!-- inputs text -->
      <div class="col-md-8">
        <div class="form-group mb-3">
          <label for="image" class="form-label">Ürün Resmi:</label>
          <input type="hidden" value="<?php echo $image; ?>" name="oldImage">
          <input type="file" name="image" id="image" class="form-control"
            value="<?php echo $image; ?>">
        </div>

        <div class="form-group mb-3">
          <label for="brand" class="form-label">Ürün Marka:</label>
          <input type="text" name="brand" id="brand" class="form-control" required
            value="<?php echo $brand; ?>">
        </div>

        <div class="form-group mb-3">
          <label for="name" class="form-label">Ürün Adı:</label>
          <input type="text" name="name" id="name" class="form-control" required
            value="<?php echo $name; ?>">
        </div>
        
        <div class="form-group mb-3">
          <label for="description" class="form-label">Ürün Açıklama:</label>
          <textarea name="description" id="description" rows="3" class="form-control"><?php echo $description; ?></textarea>
        </div>

        <div class="row g-3">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="oldPrice" class="form-label">Eski Fiyat:</label>
              <input type="text" name="oldPrice" class="form-control" value="<?php echo $oldPrice; ?>">
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="newPrice" class="form-label">Yeni Fiyat:</label>
              <input type="text" name="newPrice" class="form-control" value="<?php echo $newPrice; ?>" required>
            </div>
          </div>
        </div>
      </div>

      <!-- inputs checkboxs -->
      <div class="col-md-3 ms-auto">
        <!-- select categories -->
        <div class="card mb-3">
          <div class="card-header">Kategoriler</div>
          <div class="card-body">

            <?php $getCategories = $categoriesClass->getCategories(); ?>
            <?php foreach($getCategories as $category): ?>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="categories[]" 
                  value="<?php echo $category["id"]; ?>" id="category_<?php echo $category["id"]; ?>"
                  <?php foreach($selectedCategories as $sc){
                    if($sc == $category["id"]){ echo "checked"; }
                  } ?>
                  >
                <label class="form-check-label" for="category_<?php echo $category["id"]; ?>">
                  <?php echo $category["name"]; ?>
                </label>
              </div>
            <?php endforeach; ?>

          </div>
        </div>

        <!-- select gender -->
        <div class="card mb-3">
          <div class="card-header">Cinsiyet</div>
          <div class="card-body">
            <div class="d-flex flex-wrap gap-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" 
                  value="Erkek" id="Erkek"
                  <?php if($gender == "Erkek"){ echo "checked"; } ?>
                  required>
                <label class="form-check-label" for="Erkek">
                  Erkek
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" 
                  value="Kadın" id="Kadın"
                  <?php if($gender == "Kadın"){ echo "checked"; } ?>
                  required>
                <label class="form-check-label" for="Kadın">
                  Kadın
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- select colors -->
        <div class="card mb-3">
          <div class="card-header">Renkler</div>
          <div class="card-body">
            <?php $getColors = $colorsClass->getColors(); ?>
            <?php foreach($getColors as $color): ?>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="colors[]" 
                  value="<?php echo $color["id"]; ?>" id="color_<?php echo $color["id"]; ?>"
                  <?php foreach($selectedColors as $sc){
                    if($sc == $color["id"]){ echo "checked"; }
                  } ?>
                  >
                <label class="form-check-label" for="color_<?php echo $color["id"]; ?>">
                  <?php echo $color["name"]; ?>
                </label>
              </div>
            <?php endforeach; ?>  
          </div>
        </div>

        <!-- select small images -->
        <div class="card mb-3">
          <table class="table table-bordered table-striped table-sm mb-0">
            <thead>
              <tr>
                <th>Resim</th>
                <th style="width: 60px;">
                  <span id="addSmallImage" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></span>
                </th>
              </tr>
            </thead>
            <tbody id="tableSmallImages">
              <tr>
                <td>
                  <input type="file" name="smallImages[]" class="form-control">
                </td>
                <td>
                  <span onclick="removeSmallImage(this)" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>

    </div>

    <div class="text-center">
      <button type="submit" name="addProduct" class="btn btn-success">Ürün Ekle</button>
    </div>
  </form>
</div>        


<!-- <script>
  // add small ımage button click
  $("#addSmallImage").on("click", function(){
    let smallImageTr = `
      <tr>
        <td>
          <input onchange="smallImage(this)" type="file" name="smallImages[]" class="form-control">
        </td>
        <td>
          <button onclick="removeSmallImage(this)" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
        </td>
      </tr>
    `;
    $(smallImageTr).appendTo("#smallImagesTbody");
  });

  // remove small ımage button click
  function removeSmallImage(e){
    $(e).parent().parent().fadeOut(200);
  }
  
  // add small image jquery
  function smallImage(input){
    console.log(input)
  }

</script> -->

<!-- add and remove small images -->
<script type="text/javascript">
  // add small image
  $("#addSmallImage").on("click",function(){
    const html = `
      <tr>
        <td>
          <input type="file" name="smallImages[]" class="form-control">
        </td>
        <td>
          <span onclick="removeSmallImage(this)" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></span>
        </td>
      </tr>
    `;

    $("#tableSmallImages").append(html);
  });

  // remove small image
  function removeSmallImage(e){
    $(e).parent().parent().fadeOut(200);
  }
</script>

<?php require "views/_sidebar-finish.php"; ?>
<?php require "views/_admin-html-finish.php"; ?>
