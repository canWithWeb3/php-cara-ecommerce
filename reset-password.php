<?php 
  require "admin/libs/functions.php";
 
  if(!$usersClass->isLogged()){
    if(isset($_GET["email"]) && isset($_GET["password_token"])){
      $email = $othersClass->control_input($_GET["email"]);
      $password_token = $othersClass->control_input($_GET["password_token"]);
      if($usersClass->exits_email($email)){
        $user = $usersClass->getUserByEmail($email)->fetch(PDO::FETCH_ASSOC);
        if($user["password_token"] == $password_token){
          // $rand_token = openssl_random_pseudo_bytes(16);
          // $new_password_token = bin2hex($rand_token);
          // if($usersClass->changeUserPasswordTokenByEmail($email, $new_password_token)){
          //   header("Location: login");
          //   exit;
          // }else{
          //   echo "password token değişmedi.";
          // }
        }else{
          echo "password token uyuşmuyor";
        }
      }else{
        echo "email uyuşmuyor";
      }
    }else{
      echo "getler gelmedi.";
    }
  }else{
    header("Location: index");
    exit;
  }

  if(isset($_POST["changePassword"])){

    if(empty($_POST["password"])){
      $error = "Parola boş bırakılamaz.";
    }elseif($_POST["password"] != $_POST["repassword"]){
      $error = "Parolalar uyuşmuyor.";
    }else{
      $password = $othersClass->control_input($_POST["password"]);
    }

    if(empty($error)){
      $hash = password_hash($password, PASSWORD_DEFAULT);
      if($usersClass->changeUserPasswordByEmail($email, $hash)){
        $rand_token = openssl_random_pseudo_bytes(16);
        $password_token = bin2hex($rand_token);
        if($usersClass->changeUserPasswordTokenByEmail($email, $password_token)){
          header("Location: login");
          exit;
        }else{
          $error = "Parola yenileme hatası";
        }
      }else{
        $error = "Parola yenileme hatası";
      }
    }


  }
?>

<?php require "views/_html-start.php"; ?>
<?php require "views/_navbar.php"; ?>

<main class="main-vh">
  
  <div class="container my-5">
    <div class="col-lg-6 col-md-9 col-12 mx-auto">
      <div class="card">
        <div class="card-body">
          <h1 class="h3 text-center mb-5">Change Password</h1>

          <!-- show success -->
          <?php if(!empty($success)): ?>
            <div class="alert alert-success mb-3">
              <p class="mb-0"><?php echo $success; ?></p>
            </div>
          <?php endif; ?>  

          <!-- show error -->
          <?php if(!empty($error)): ?>
            <div class="alert alert-warning mb-3">
              <p class="mb-0"><?php echo $error; ?></p>
            </div>
          <?php endif; ?>  

          <!-- change password form -->
          <form method="POST" class="my-3">
            <div class="form-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <div class="form-group mb-3">
              <input type="password" name="repassword" class="form-control" placeholder="Repassword">
            </div>
            
            <!-- change password form submit button -->
            <div class="text-end">
              <button type="submit" name="changePassword" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</main>


<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>