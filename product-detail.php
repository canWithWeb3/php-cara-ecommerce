<?php 
  require "admin/libs/functions.php";

  if(!isset($_GET["slug"])){
    header("Location: ".$host);
    exit;
  }else{
    $_GET["slug"] = $othersClass->control_input($_GET["slug"]);
  }

  $product = $productsClass->getProductBySlug($_GET["slug"])->fetch(PDO::FETCH_ASSOC);
  if($product["id"] == null){
    header("Location: ".$host);
  }

  $comment_err = "";
  if(isset($_POST["addComment"])){
    if(empty($_POST["comment"])){
      $comment_err = "Comment is empty";
    }else{
      $comment = $othersClass->control_input($_POST["comment"]);
    }

    if(empty($comment_err)){
      $loggedUser = $usersClass->getLogged()->fetch(PDO::FETCH_ASSOC);
      if(!$productCommentsClass->addCommentToProduct($product["id"],$loggedUser["id"],$comment)){
        $comment_err = "Comment error";
      }
    }

  }


?>

<?php require "views/_html-start.php"; ?>
<?php require "views/_navbar.php"; ?>

<main class="main-vh py-5">
  <div class="container">
    <div class="row g-lg-5 g-4 mb-5">
      <div class="col-lg-4">
        <img src="<?php echo $host; ?>/admin/image/<?php echo $product["image"]; ?>" alt="" id="bigImage" class="animate img-fluid mb-2">
        <div class="row g-1">
          <div class="col-xl-3 col-4">
            <img src="<?php echo $host; ?>/admin/image/<?php echo $product["image"]; ?>" alt="" class="smallImage img-fluid cursor-pointer border border-success">
          </div>  
          <?php $smallImages = $filesClass->getSmallImagesByProductId($product["id"]) ?>
          <?php foreach($smallImages as $key => $sm): ?>
            <div class="col-xl-3 col-4">
              <img src="<?php echo $host; ?>/admin/image/<?php echo $sm["image"]; ?>" alt="" class="smallImage img-fluid cursor-pointer border">
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-lg-8">
        <h1 class="h3 mb-4 fw-bold"><?php echo $product["name"]; ?></h1>
        <div class="d-flex gap-2 mb-3">
          <?php if(!empty($product["oldPrice"])): ?>
            <p class="text-secondary h4 text-decoration-line-through fw-bold mb-0">$<?php echo $product["oldPrice"]; ?></p>
          <?php endif; ?>
          <p class="text-primary h4 fw-bold mb-0">$<?php echo $product["newPrice"]; ?></p>
        </div>

        <!-- <form method="POST"> -->
          <!-- sizes and colors -->
          <div class="d-flex gap-3 flex-wrap mb-3">
            <!-- sizes -->
            <select style="width: 140px;" class="form-select mb-3" aria-label="Default select example" required>
              <option value="" disabled selected>Select Size</option>
              <option value="1">S</option>
              <option value="2">M</option>
              <option value="3">L</option>
              <option value="3">XL</option>
            </select>

            <!-- colors -->
            <div class="d-flex flex-wrap gap-2 mb-3">
              <?php $getProductColors = $productColorsClass->getProductColorsByProductId($product["id"]); ?>
              <?php foreach($getProductColors as $key => $gpc): ?>
                <?php $color = $colorsClass->getColorById($gpc["colorId"])->fetch(PDO::FETCH_ASSOC); ?>
                <div onclick="changeColor(this)" title="<?php echo $color["name"]; ?>"
                  style="height:40px; width:40px; background-color:<?php echo $color["color"]; ?>;" 
                  class="color rounded-circle product-detail-color <?php if($key == 0){ echo "color-active"; } ?>">
            
                </div>
              <?php endforeach; ?>  
            </div>
          </div>

          <!-- quantity and submit btn -->
          <div class="d-flex gap-3 mb-5">
            <!-- quantity -->
            <input style="width: 86px;" type="number" class="form-control" value="1" min="1" max="13" required>
            <!-- submit btn -->
            <button onclick="addUserCart(<?php echo $product['id']; ?>)" type="submit" name="addToCart" class="btn btn-success">Add To Cart</button>
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
        <!-- </form> -->


        <div>
          <h4 class="fw-bold">Product Details</h4>
          <div>
            <p class="product-detail-text less-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facilis odit. A facere sint possimus molestias maiores aspernatur voluptatibus porro hic ipsum aut? Non impedit aliquid animi optio ex, iure harum exercitationem doloremque mollitia aliquam voluptatum sunt, at amet voluptates quisquam dolores saepe dolorem eligendi esse reiciendis ullam, natus perferendis. Voluptates id ducimus voluptatum corrupti reiciendis a veritatis debitis laudantium quo pariatur eaque assumenda itaque dolore reprehenderit inventore temporibus labore est, nihil aspernatur expedita accusantium, modi praesentium distinctio! Molestias, velit alias dolor non voluptatem eos cupiditate excepturi exercitationem quisquam repudiandae temporibus! Ab tenetur, amet iusto reiciendis et sapiente ratione quis ipsa explicabo alias! Quod perspiciatis nulla fugiat a hic, itaque rem explicabo dolorem similique, neque atque debitis dolores eos et. Quia vel temporibus impedit numquam eius magnam totam cupiditate porro aspernatur reprehenderit fuga reiciendis, tempore et atque natus excepturi, sit illo similique, dignissimos blanditiis. Nam esse perspiciatis quibusdam voluptate consequuntur accusantium excepturi natus deserunt modi.</p>
            <button onclick="toggleProductDetail(this)" class="btn btn-secondary">Read More</button>
            <script>
              function toggleProductDetail(btn){
                const productDetailText = document.querySelector(".product-detail-text");
                if(productDetailText.classList.contains("less-text")){
                  productDetailText.classList.remove("less-text")

                  btn.classList.remove("btn-secondary")
                  btn.classList.add("btn-danger")
                  btn.textContent = "Read Less";
                }else{
                  productDetailText.classList.add("less-text")

                  btn.classList.add("btn-secondary")
                  btn.classList.remove("btn-danger")
                  btn.textContent = "Read More";
                }
              }
            </script>
          </div>
        </div>
      </div>
      
    </div>

    <!-- comments -->
    <div>
      <h1 class="h2 text-center mb-3">Comments</h1>

      <?php if($usersClass->isLogged()): ?>
        <!-- add comment form -->
        <div class="card mb-3">
          <div class="card-header">Add Comment</div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-3">
                <textarea name="comment" id="" cols="30" rows="3" class="form-control" placeholder="Your Comment"></textarea>
              </div>

              <div class="text-center">
                <button type="submit" name="addComment" class="btn btn-outline-success">Submit</button>
              </div>
            </form>
          </div>
        </div>
      <?php endif; ?>

      <?php $getProductComments = $productCommentsClass->getProductCommentsByProductId($product["id"]); ?>
      <?php if($getProductComments->rowCount() > 0): ?>
        <div class="d-flex flex-column gap-3">
          <?php foreach($getProductComments as $pc): ?>
            <?php if($pc["id"] != null): ?>
              <?php $user = $usersClass->getUserById($pc["userId"])->fetch(PDO::FETCH_ASSOC); ?>
              <?php if($user["id"] != null): ?>
                <div class="card">
                  <div class="card-body">
                    <div class="w-100">
                      <h5 class="card-title"><?php echo $user["username"]; ?></h5>
                      <hr>
                      <p><?php echo $pc["comment"]; ?></p>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endif; ?>  
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-warning text-center">
          <p>No Comments</p>
        </div>
      <?php endif; ?>  
    </div>
  </div>  

</main>

<script>
  function changeColor(e){
    $(".color").each(function(){
      $(this).removeClass("color-active");
    })

    e.classList.add("color-active");
  }
</script>

<!-- change smallImage -->
<script type="text/javascript">
  const bigImage = document.getElementById("bigImage");
  $(".smallImage").on("click", function(e){
    const selectedImage = e.target;
    if(!selectedImage.classList.contains("border-success")){
      $(".smallImage").each(function(){
      $(this).removeClass("border-success")
      })

      $(selectedImage).addClass("border-success");
      $(bigImage)
        .fadeOut(22)
        .attr("src", selectedImage.getAttribute("src"))
        .fadeIn(200);
    }
    
  });
</script>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
