<?php 
  require "libs/functions.php"
?>

<?php require "views/_admin-html-start.php"; ?>
<?php require "views/_sidebar-start.php"; ?>


<div>
  <div class="d-flex justify-content-between mb-4">
    <h1 class="h3">Kategoriler</h1>
    
    <a href="add-category" class="btn btn-success">Kategori Ekle</a>
  </div>
  
  <table id="table" class="table table-striped table-bordered mb-0">
    <thead>
      <tr>
        <th>Adı</th>
        <th style="width: 110px;"></th>
      </tr>
    </thead>
    <tbody>
      <?php $getCategories = $categoriesClass->getCategories(); ?>
      <?php foreach($getCategories as $category): ?>
        <tr>
          <td><?php echo $category["name"]; ?></td>
          <td class="d-flex gap-3 flex-wrap">
            <a href="edit-category?id=<?php echo $category["id"]; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
            <a href="delete-category?id=<?php echo $category["id"]; ?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>        


<?php require "views/_sidebar-finish.php"; ?>
<?php require "views/_admin-html-finish.php"; ?>
