<?php 
  require "../admin/libs/functions.php";

  $selectedCategory = $othersClass->control_input($_POST["selectedCategory"]);

  if(!empty($selectedCategory)){
    $getProductCategories = $productCategoriesClass->getProductCategoriesByCategoryId($selectedCategory)->fetch(PDO::FETCH_ASSOC);
    $getProducts = $productsClass->getProductById($getProductCategories["productId"]);
    foreach($getProducts as $p){ ?>
       <div class="col-xl-3 col-lg-4 col-6">
          <div class="card br-25">
            <div class="card-body position-relative">
              <a href="product-detail?slug=<?php echo $product["slug"]; ?>">
                <img src="admin/image/<?php echo $product["image"]; ?>" alt="" class="img-fluid mb-2 br-25">
              </a>
              <span class="text-secondary d-inline-block mb-1">adidas</span>
              <h1 class="fs-6 fw-bold text-dark"><?php echo $product["name"]; ?></h1>
              <div class="product-stars mb-2">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
              </div>
              <div class="d-flex gap-2">
                <?php if(!empty($product["oldPrice"])): ?>
                  <p class="text-secondary text-decoration-line-through fw-bold mb-0">$<?php echo $product["oldPrice"]; ?></p>
                <?php endif; ?>
                <p class="text-primary fw-bold mb-0">$<?php echo $product["newPrice"]; ?></p>
              </div>
              <div class="position-absolute bottom-0 end-0 me-3 mb-3">
                <button onclick="addUserCart(<?php echo $product['id']; ?>)" class="btn btn-primary2 br-25">
                  <i class="fa-solid fa-cart-shopping"></i>
                </button>
              </div>
            </div>
          </div>
      </div>

    <?php }
  }

?>