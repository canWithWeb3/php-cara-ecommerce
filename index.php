<?php 
  require "admin/libs/functions.php"
?>

<?php require "views/_html-start.php"; ?>
<?php require "views/_navbar.php"; ?>


<main class="main-vh">
  <!-- header image -->
  <section id="hero" class="position-relative">
    <img src="img/hero4.png" alt="" class="hero-img">
    <div class="hero-content position-absolute top-50 start-25 translate-middle-y text-lg-start text-center">
      <p class="fw-bold fs-5">Trade-in-offer</p>
      <h1 class="fw-bold">Super value deals</h3>
      <h1 class="text-primary fw-bold">On all products</h1>
      <span class="fs-6 text-secondary d-block mb-4">Save more with coupons & up to 70% off!</span>
      <a href="shop" class="btn btn-hero ms-3">Shop Now</a>
    </div>
  </section>

  <!-- featured arrivals -->
  <section class="py-5">
    <div class="text-center mb-5">
      <h1 class="fw-bold">Featured  Products</h1>
      <p class="text-secondary">Summer Collection New Morden Design</p>
    </div>

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
  </section>

  <!-- banner  -->
  <section id="banner" class="my-5">
    <p class="text-white fw-bold fs-5">Repair Services</p>
    <h1 class="h3 text-white mb-4 fw-bold">Up to <span class="text-danger">70% Off</span> - All T-Shirts & Accessories</h1>
    <button class="btn banner-button fw-bold">Explode More</button>
  </section>

  <!-- blogs -->
  <section class="my-5">
    <div class="container">
      <div class="row g-3">
        <div class="col-lg-6">
          <div class="card position-relative">
            <img style="height: 350px;" src="img/banner/b17.jpg" alt="" class="img-fluid">
            <div class="position-absolute top-50 start-0 translate-middle-y ms-lg-5 ms-3">
              <span class="d-block fs-5 text-light mb-1">crazy deals</span>
              <h1 class="h3 fw-bolder text-light">but 1 get 1 free</h1>
              <p class="text-light">The best classic dress is on sale at cora</p>
              <button class="btn btn-outline-light">Learn More</button>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card position-relative">
            <img style="height: 350px;" src="img/banner/b10.jpg" alt="" class="img-fluid">
            <div class="position-absolute top-50 start-0 translate-middle-y ms-lg-5 ms-3">
              <span class="d-block fs-5 text-light mb-1">spring/summer</span>
              <h1 class="h3 fw-bolder text-light">upcomming season</h1>
              <p class="text-light">The best classic dress is on sale at cora</p>
              <button class="btn btn-outline-light">Collection</button>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card position-relative">
            <img style="height: 350px;" src="img/banner/b7.jpg" alt="" class="img-fluid">
            <div class="position-absolute top-50 start-0 translate-middle-y ms-lg-5 ms-3">
              <h1 class="h3 fw-bolder text-light">SEASONAL SALE</h1>
              <p class="text-danger fw-bold">Winter Collection -50% Off</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card position-relative">
            <img style="height: 350px;" src="img/banner/b4.jpg" alt="" class="img-fluid">
            <div class="position-absolute top-50 start-0 translate-middle-y ms-lg-5 ms-3">
              <h1 class="h3 fw-bolder text-light">NEW FOOTWEAR COLLECTION</h1>
              <p class="text-danger fw-bold">Spring / Summer 2022</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card position-relative">
            <img style="height: 350px;" src="img/banner/b18.jpg" alt="" class="img-fluid">
            <div class="position-absolute top-50 start-0 translate-middle-y ms-lg-5 ms-3">
            <h1 class="h3 fw-bolder text-light">SEASONAL SALE</h1>
              <p class="text-danger fw-bold">New Trendly Prints</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- sign up -->
  <section class="newslettersSection my-5 py-5">
    <div class="container py-5">
      <div class="d-flex align-items-center justify-content-between flex-wrap text-lg-start text-center">
        <div class="text-light mb-lg-0 mb-4">
          <h1 class="h3 mb-4">Sign Up For Newsletters</h1>
          <span class="d-block">Get E-mail updates about our latest shop and <span class="text-warning">specials offers</span></span>
        </div>
        <div class="mx-auto ms-md-auto ">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Your email address" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <button class="btn btn-success px-3 py-2" id="basic-addon2">Sign Up</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
