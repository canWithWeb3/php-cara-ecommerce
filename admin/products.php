<?php 
  require "libs/functions.php"
?>

<?php require "views/_admin-html-start.php"; ?>
<?php require "views/_sidebar-start.php"; ?>


<div>
  <div class="d-flex justify-content-between mb-4">
    <h1 class="h3">Ürünler</h1>
    
    <a href="add-product" class="btn btn-success">Ürün Ekle</a>
  </div>
  
  <table id="table" class="table table-striped table-bordered mb-0">
    <thead>
      <tr>
        <th style="width: 70px;">Resim</th>
        <th>Adı</th>
        <th>Açıklama</th>
        <th style="width: 70px;">Eski<br>Fiyat</th>
        <th style="width: 70px;">Yeni<br>Fiyat</th>
        <th style="width: 90px;"></th>
      </tr>
    </thead>
    <tbody>
      <?php $getProducts = $productsClass->getProducts(); ?>
      <?php foreach($getProducts as $product): ?>
        <tr>
          <td class="p-0"><img src="image/<?php echo $product["image"]; ?>" class="img-fluid" alt=""></td>
          <td><?php echo $product["name"]; ?></td>
          <td><?php echo $product["description"]; ?></td>
          <td><?php echo $product["oldPrice"]; ?></td>
          <td><?php echo $product["newPrice"]; ?></td>
          <td>
            <a href="edit-product?id=<?php echo $product["id"]; ?>" class="btn btn-warning btn-sm d-lg-inline-block d-block me-lg-2 me-0 mb-lg-0 mb-3"><i class="fas fa-edit"></i></a>
            <a href="delete-product?id=<?php echo $product["id"]; ?>" class="btn btn-danger btn-sm d-lg-inline-block d-block"><i class="fas fa-times"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>        




<?php require "views/_sidebar-finish.php"; ?>
<?php require "views/_admin-html-finish.php"; ?>
