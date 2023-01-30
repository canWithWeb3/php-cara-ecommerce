<?php 
  require "libs/functions.php"
?>

<?php require "views/_admin-html-start.php"; ?>
<?php require "views/_sidebar-start.php"; ?>


<div>
  <div class="d-flex justify-content-between mb-4">
    <h1 class="h3">Renkler</h1>
    
    <a href="add-color" class="btn btn-success">Renk Ekle</a>
  </div>
  
  <table id="table" class="table table-striped table-bordered mb-0">
    <thead>
      <tr>
        <th style="width: 40px;">Resim</th>
        <th>Adı</th>
        <th style="width: 90px;"></th>
      </tr>
    </thead>
    <tbody>
      <?php $getColors = $colorsClass->getColors(); ?>
      <?php foreach($getColors as $product): ?>
        <tr>
          <td class="p-0"><div style="background-color: <?php echo $product["color"]; ?>; height:40px;"></div></td>
          <td><?php echo $product["name"]; ?></td>
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
