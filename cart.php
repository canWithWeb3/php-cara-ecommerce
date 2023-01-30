<?php 
  require "admin/libs/functions.php"
?>

<?php require "views/_html-start.php"; ?>
<?php require "views/_navbar.php"; ?>


<main class="main-vh py-5">
  
  <div class="container">
    <!-- table -->
    <table class="table table-striped table-hover mb-5">
      <thead>
        <tr>
          <th style="width: 70px;">Image</th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th style="width: 60px;">Remove</th>
        </tr>
      </thead>
      <tbody>
        <?php if($usersClass->isLogged()): ?>
          <?php $user = $usersClass->getLogged()->fetch(PDO::FETCH_ASSOC); ?>
          <?php $getProducts = $userCartsClass->getUserProductsByUserId($user["id"]); ?>
          <?php foreach($getProducts as $product): ?>
            <?php if($product["id"] != null): ?>
              <?php $p = $productsClass->getProductById($product["productId"])->fetch(PDO::FETCH_ASSOC); ?>
              <tr>
                <td class="p-0"><img src="admin/image/<?php echo $p["image"]; ?>" alt="" class="img-fluid"></td>
                <td><?php echo $p["name"]; ?></td>
                <td><?php echo "$".$p["newPrice"]; ?></td>
                <td><?php echo $product["count"]; ?></td>
                <td><?php echo "$".$product["count"] * $p["newPrice"]; ?></td>
                <td>
                  <button onclick="deleteUserCart(this)" data-id="<?php echo $product["id"]; ?>" style="background-color: #B39AD1 !important;" class="btn btn-sm text-white"><i class="fas fa-times"></i></button>
                  <script>
                    function deleteUserCart(btn){
                      const id = $(btn).data("id");
                      $.ajax({
                        url: "post/deleteCartProduct.php",
                        type: "POST",
                        data: {
                          id: id
                        },
                        success: function(res){
                          getNavbarCartCount();
                          getCartTotalPrice();
                          $(btn).parent().parent().fadeOut(400)
                        },error: function(){
                          console.log("ürün carttan silinemedi")
                        }
                      })
                    }
                  </script>
                </td>
              </tr>
            <?php endif; ?>  
          <?php endforeach; ?>
        <?php endif; ?>  
      </tbody>
    </table>

    <?php if($usersClass->isLogged()): ?>
      <div class="d-flex justify-content-md-between justify-content-end flex-wrap">
          <div>
            <h4 class="fw-bold mb-3">Apply Cuppon</h4>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Try myCoppon" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <button class="btn btn-success" id="basic-addon2">Apply</button>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h4 class="mb-4">Cart Totals</h4>

              <div class="d-flex mb-4">
                <ul class="list-group">
                  <li class="list-group-item px-md-5">Cart Subtotal</li>
                  <li class="list-group-item px-md-5">Shipping</li>
                  <li class="list-group-item px-md-5 fw-bold">Total</li>
                </ul>
                <ul class="list-group">
                  <li class="cartTotalPrice list-group-item px-md-5">$0</li>
                  <li class="list-group-item px-md-5 ">Free</li>
                  <li class="cartTotalPrice list-group-item px-md-5 fw-bold">$0</li>
                </ul>
              </div>

              <button class="btn btn-success">Proceed to checkout</button>
            </div>
          </div>
      </div>
    <?php endif; ?>
  </div>
  
</main>

<script>
  $(document).ready(function(){
    getCartTotalPrice();
  })

  function getCartTotalPrice(){
    $.ajax({
      url: "post/getCartTotalPrice.php",
      type: "POST",
      success: function(res){
        console.log(res)
        $(".cartTotalPrice").text(res);
      },
      error: function(){
        console.log("cart toplam fiyat gelmedi.");
      }
    })
    
  }
</script>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
