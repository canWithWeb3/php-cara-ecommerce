<?php 

$host = "http://" . $_SERVER['HTTP_HOST'];
session_start();


class GooogleLoginApi{

  public function GetAccessToken($client_id,$redirect_uri,$client_secret,$code){

      $url = 'https://www.googleapis.com/oauth2/v4/token';
      $curlPost = 'client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&client_secret='.$client_secret.'&code='.$code.'&grant_type=authorization_code';

      $ch  = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
      $data2 = curl_exec($ch);
      $data  = json_decode($data2,true);
      return $data;

  }

  public function GetUserProfileInfo($access_token){

      $url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email';

      $ch  = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.  $access_token));
      $data2 = curl_exec($ch);
      $data  = json_decode($data2,true);
      return $data;


  }

}

class Users{

  function isLogged(){
    $email = $hash = "";
    if(isset($_SESSION["email"]) && isset($_SESSION["hash"])){
      $email = $_SESSION["email"];
      $hash = $_SESSION["hash"];
    }elseif(isset($_COOKIE["email"]) && isset($_COOKIE["hash"])){
      $email = $_COOKIE["email"];
      $hash = $_COOKIE["hash"];
    }

    if($this->exits_email($email)){
      $user = $this->getUserByEmail($email)->fetch(PDO::FETCH_ASSOC);
      if($user["password"] == $hash){
        return true;
      }
    }

    return false;
  }

  function isAdmin(){
    $email = $hash = "";
    if(isset($_SESSION["email"]) && isset($_SESSION["hash"])){
      $email = $_SESSION["email"];
      $hash = $_SESSION["hash"];
    }elseif(isset($_COOKIE["email"]) && isset($_COOKIE["hash"])){
      $email = $_COOKIE["email"];
      $hash = $_COOKIE["hash"];
    }

    if($this->isLogged()){
      if($this->exits_email($email)){
        $user = $this->getUserByEmail($email)->fetch(PDO::FETCH_ASSOC);
        if($user["password"] == $hash && $user["type"] == "admin"){
          return true;
        }
      }
    }

    return false;
  }

  function getLogged(){
    $email = $hash = "";
    if(isset($_SESSION["email"]) && isset($_SESSION["hash"])){
      $email = $_SESSION["email"];
      $hash = $_SESSION["hash"];
    }elseif(isset($_COOKIE["email"]) && isset($_COOKIE["hash"])){
      $email = $_COOKIE["email"];
      $hash = $_COOKIE["hash"];
    }

    if($this->exits_email($email)){
      require "connect.php";

      $query = $db->prepare("SELECT * FROM users WHERE email=:email");
      $query->execute(["email" => $email]);

      return $query;
    }

    return false;
  }

  function getUserById($id){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM users WHERE id=:id");
    $query->execute(["id" => $id]);

    return $query;
  }

  function getUserByEmail($email){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM users WHERE email=:email");
    $query->execute(["email" => $email]);

    return $query;
  }

  function addUser($username, $email, $password){
    require "connect.php";

    $query = $db->prepare("INSERT INTO users SET 
      username=:username,
      email=:email,
      password=:password
    ");

    $control = $query->execute([
      "username" => $username,
      "email" => $email,
      "password" => $password
    ]);

    if($control){ return true; }else { return false; }
  }

  function exits_email($email){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM users WHERE email=:email");
    $query->execute(["email" => $email]);

    if($query->rowCount() > 0){ return true; }else { return false; }
  }

  function changeUserPasswordTokenByEmail($email,$password_token){
    require "connect.php";

    $query = $db->prepare("UPDATE users SET 
      password_token=:password_token
      WHERE email=:email
    ");

    $control = $query->execute(array(
      "password_token" => $password_token,
      "email" => $email
    ));

    if($control){
      return true;
    }else{
      return false;
    }
  }

  function changeUserPasswordByEmail($email,$password){
    require "connect.php";

    $query = $db->prepare("UPDATE users SET 
      password=:password
      WHERE email=:email
    ");

    $control = $query->execute(array(
      "password" => $password,
      "email" => $email
    ));

    if($control){
      return true;
    }else{
      return false;
    }
  }

}

class Products{
  function getProducts(){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM products");
    $query->execute();

    return $query;
  }

  function getProductById($id){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM products WHERE id=:id");
    $query->execute(["id" => $id]);

    return $query;
  }

  function getLastProduct(){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 0,1");
    $query->execute();

    return $query;
  }

  function addProduct($image,$brand,$name,$description,$oldPrice,$newPrice,$gender,$slug){
    require "connect.php";
    $query = $db->prepare("INSERT INTO products SET 
      image=:image,
      brand=:brand,
      name=:name,
      description=:description,
      oldPrice=:oldPrice,
      newPrice=:newPrice,
      gender=:gender,
      slug=:slug
    ");

    $control = $query->execute([
      "image" => $image,
      "brand" => $brand,
      "name" => $name,
      "description" => $description,
      "oldPrice" => $oldPrice,
      "newPrice" => $newPrice,
      "gender" => $gender,
      "slug" => $slug
    ]);

    if($control){ return true; }else{ return false; }
  }

  function editProductById($id,$image,$brand,$name,$description,$oldPrice,$newPrice,$gender,$slug){
    require "connect.php";
    $query = $db->prepare("UPDATE products SET 
      image=:image,
      brand=:brand,
      name=:name,
      description=:description,
      oldPrice=:oldPrice,
      newPrice=:newPrice,
      gender=:gender,
      slug=:slug
      WHERE id=:id
    ");

    $control = $query->execute([
      "image" => $image,
      "brand" => $brand,
      "name" => $name,
      "description" => $description,
      "oldPrice" => $oldPrice,
      "newPrice" => $newPrice,
      "gender" => $gender,
      "slug" => $slug,
      "id" => $id
    ]);

    if($control){ return true; }else{ return false; }
  }

  function getProductBySlug($slug){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM products WHERE slug=:slug");
    $query->execute(array(
      "slug" => $slug
    ));

    return $query;
  }

}

class Categories{

  function getCategories(){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM categories");
    $query->execute();

    return $query;
  }

  function getCategoryById($id){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM categories WHERE id=:id");
    $query->execute(["id" => $id]);

    return $query;
  }

  function addCategory($name){
    require "connect.php";

    $query = $db->prepare("INSERT INTO categories SET name=:name");
    $control = $query->execute([
      "name" => $name
    ]);

    return $control;
  }

  function editCategoryById($id){
    require "connect.php";

    $query = $db->prepare("UPDATE FROM categories SET
      name=:name
      WHERE id=:id"
    );

    $query->execute([
      "name" => $name,
      "id" => $id
    ]);

    return $query;
  }
}

class Colors{

  function getColors(){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM colors");
    $query->execute();

    return $query;
  }

  function getColorById($id){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM colors WHERE id=:id");
    $query->execute(["id" => $id]);

    return $query;
  }

  function addColor($color, $name){
    require "connect.php";

    $query = $db->prepare("INSERT INTO colors SET color=:color, name=:name");
    $query->execute(array(
      "color" => $color,
      "name" => $name
    ));

    return $query;
  }

}

class ProductCategories{

  function addProductCategories($productId, $categories){
    require "connect.php";

    foreach($categories as $categoryId){
      $query = $db->prepare("INSERT INTO product_categories SET 
        productId=:productId,
        categoryId=:categoryId
      ");

      $control = $query->execute([
        "productId" => $productId,
        "categoryId" => $categoryId
      ]);
    }

    if($control){ return true; }else{ return false; }
  }

  function getProductCategoriesByProductId($productId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM product_categories WHERE productId=:productId");
    $query->execute(["productId" => $productId]);

    return $query;
  }

  function getProductCategoriesByCategoryId($categoryId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM product_categories WHERE categoryId=:categoryId");
    $query->execute(["categoryId" => $categoryId]);

    return $query;
  }

  function clearProductCategoriesByProductId($productId){
    require "connect.php";

    $query = $db->prepare("DELETE FROM product_categories WHERE productId=:productId");
    $control = $query->execute(["productId" => $productId]);

    if($control){return true;}else{return false;}
  }

}

class ProductColors{

  function getProductColorsByProductId($productId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM product_colors WHERE productId=:productId");
    $query->execute(["productId" => $productId]);

    return $query;
  }

  function addProductColors($productId, $colors){
    require "connect.php";

    foreach($colors as $colorId){
      $query = $db->prepare("INSERT INTO product_colors SET 
        productId=:productId,
        colorId=:colorId
      ");

      $control = $query->execute([
        "productId" => $productId,
        "colorId" => $colorId
      ]);
    }

    if($control){ return true; }else{ return false; }
  }

  function clearProductColorsByProductId($productId){
    require "connect.php";

    $query = $db->prepare("DELETE FROM product_colors WHERE productId=:productId");
    $control = $query->execute(["productId" => $productId]);

    if($control){return true;}else{return false;}
  }

}

class ProductComments{

  function getProductCommentsByProductId($productId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM product_comments WHERE productId=:productId");

    $query->execute(array(
      "productId" => $productId ));

    return $query;
  }

  function addCommentToProduct($productId,$userId,$comment){
    require "connect.php";

    $query = $db->prepare("INSERT INTO product_comments SET 
      productId=:productId,
      userId=:userId,
      comment=:comment
    ");

    $control = $query->execute(array(
      "productId" => $productId,
      "userId" => $userId,
      "comment" => $comment
    ));

    if($control){ return true; }else{ return false; }
  }

}

class UserCarts{

  function getUserProductsByUserId($userId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM user_carts WHERE userId=:userId");
    $query->execute(["userId" => $userId]);

    return $query;
  }

  function getUserCartByUserId($userId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM user_carts WHERE userId=:userId");
    $query->execute(["userId" => $userId]);

    return $query;
  }

  function addUserCart($userId, $productId){
    require "connect.php";

    $query = $db->prepare("INSERT INTO user_carts SET userId=:userId, productId=:productId");
    $query->execute(["userId" => $userId, "productId" => $productId]);

    return $query;
  }

  function editUserCartProductCount($id, $count){
    require "connect.php";

    $query = $db->prepare("UPDATE user_carts SET 
      count=:count
      WHERE id=:id
    ");

    $control = $query->execute(array(
      "count" => $count,
      "id" => $id
    ));

    return $control;
  }

  function deleteUserProduct($id){
    require "connect.php";

    $query = $db->prepare("DELETE FROM user_carts WHERE id=:id");
    $control = $query->execute(["id" => $id]);

    return $control;
  }

  function getUserCartByUserIdAndProductId($userId, $productId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM user_carts WHERE userId=:userId AND productId=:productId");
    $query->execute(array(
      "userId" => $userId,
      "productId" => $productId
    ));

    return $query;
  }


}

class Files{

  function getSmallImagesByProductId($productId){
    require "connect.php";

    $query = $db->prepare("SELECT * FROM product_images WHERE productId=:productId");
    $query->execute(["productId" => $productId]);

    return $query;
  }

  function addSmallImagesToProduct($productId, $image){
    require "connect.php";

    $query = $db->prepare("INSERT INTO product_images SET 
      productId=:productId,
      image=:image
    ");

    $control = $query->execute(array(
      "productId" => $productId,
      "image" => $image
    ));

    if($control){return true;}else{return false;}
  }

  function deleteSmallImageById($id){
    require "connect.php";

    $query = $db->prepare("DELETE product_images WHERE id=:id");

    $control = $query->execute(array(
      "id" => $id
    ));

    if($control){return true;}else{return false;}
  }

}

class Others{
  function control_input($data){
    // $data = strip_tags($data);
    $data = htmlspecialchars($data);
    // $data = htmlentities($data);
    $data = stripslashes($data); # sql injection

    return trim($data);
  }

  function saveImage($file) {
    $message = ""; 
    $uploadOk = 1;
    $fileTempPath = $file["tmp_name"];
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $maxfileSize = ((1024 * 1024) * 1);
    $dosyaUzantilari = array("jpg","jpeg","png");
    $uploadFolder = "./image/";

    if($fileSize > $maxfileSize) {
        $message = "Dosya boyutu fazla.<br>";
        $uploadOk = 0;
    }

    $dosyaAdi_Arr = explode(".", $fileName);
    $dosyaAdi_uzantisiz = $dosyaAdi_Arr[0];
    $dosyaUzantisi = $dosyaAdi_Arr[1];

    if(!in_array($dosyaUzantisi, $dosyaUzantilari)) {
        $message .= "dosya uzantısı kabul edilmiyor.<br>";
        $message .= "kabul edilen dosya uzantıları : ".implode(", ", $dosyaUzantilari)."<br>";
        $uploadOk = 0;
    }

    $yeniDosyaAdi = md5(time().$dosyaAdi_uzantisiz).'.'.$dosyaUzantisi;
    $dest_path = $uploadFolder.$yeniDosyaAdi;

    if($uploadOk == 0) {
        $message .= "Dosya yüklenemedi.<br>";
    } else {
        if(move_uploaded_file($fileTempPath, $dest_path)) {
            $message .="dosya yüklendi.<br>";
        }
    }

    return array(
        "isSuccess" => $uploadOk,
        "message" => $message,
        "image" => $yeniDosyaAdi
    );
  }

  function stringToSlug($str){
    $str = mb_strtolower($str, "UTF-8");

    $str = str_replace(
      ["ı","ş","ü","ğ","ç","ö"],
      ["i","s","u","g","c","o"],
      $str
    );

    $str = preg_replace("/[^a-z0-9]/", "-", $str);
    $str = preg_replace("/-+/", "-", $str);
    $str = trim($str, "-");

    return $str;
  }
}

$usersClass = new Users();
$productsClass = new Products();
$categoriesClass = new Categories();
$colorsClass = new Colors();
$productCategoriesClass = new ProductCategories();
$productColorsClass = new ProductColors();
$productCommentsClass = new ProductComments();
$userCartsClass = new UserCarts();
$filesClass = new Files();
$othersClass = new Others();

?>