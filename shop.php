<?php 
  require "admin/libs/functions.php"
?>

<?php require "views/_html-start.php"; ?>
<?php require "views/_navbar.php"; ?>

<main class="main-vh py-5 px-3">
  
  <div class="container">
    <div class="row g-3">

      <?php $getProducts = $productsClass->getProducts(); ?>
      <?php foreach($getProducts as $product): ?>

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

      <?php endforeach; ?>   

      <script>
        function addUserCart(productId){
          <?php if($usersClass->isLogged()): ?>
            $.ajax({
              url: "post/addUserCart.php",
              type: "POST",
              data: {
                productId: productId
              },
              success: function(res){
                getNavbarCartCount();
                swal({
                  title: res,
                  icon: "success",
                });
              },error: function(){
                swal({
                  title: "Sepete eklenemedi.",
                  icon: "error",
                });
              }
            })
            
          <?php else: ?>  
            swal({
              title: "Giriş Yapmadınız",
              icon: "error",
            });
          <?php endif; ?>  
        }
      </script>

    </div>
  </div>

</main>

<script type="text/javascript">
  function getProducts(e){
    const categories = document.querySelectorAll(".category");
    let selectedCategory = e.value
    categories.forEach(c => {
      c.checked = false;
    })
    e.checked = true;

    $.ajax({
      url: "post/getProductsToShop.php",
      type: "POST",
      data: {
        selectedCategory: selectedCategory
      },
      success: function(res){
        $(".getProducts").html(res)
      },error: function(){
        $(".getProducts").html(`
          <div class='alert alert-warning text-center'>
            Ürün Bulunamadı.
          </div>
        `)
      }
    })
  }
</script>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
