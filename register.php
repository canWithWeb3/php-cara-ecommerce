<?php 
  require "admin/libs/functions.php";
  require 'admin/libs/connect.php';
  require 'google-settings.php';
  
  $login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
  
  if($usersClass->isLogged()){
    header("Location: index");
    exit;
  }

  $username = $email = $password = $repassword = "";
  $username_err = $email_err = $password_err = "";
  $error = "";

  // isset signUp
  if(isset($_POST["signUp"])){

    // username validation
    if(empty(trim($_POST["username"]))){
      $username_err = "Kullanıcı adı boş geçilemez.";
    }elseif(strlen(trim($_POST["username"]) < 3) || strlen(trim($_POST["username"])) > 15){
      $username_err = "Kullanıcı adı 3 ile 15 karakter içerebilir.";
    }else{
      $username = $othersClass->control_input($_POST["username"]);
    }

    // email validation
    if(empty(trim($_POST["email"]))){
      $email_err = "Email boş geçilemez.";
    }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $email_err = "Geçerli email giriniz.";
    }else{
      $email = $othersClass->control_input($_POST["email"]);
    }

    // password validation
    if(empty(trim($_POST["password"]))){
      $password_err = "Parola boş geçilemez.";
    }elseif(strlen(trim($_POST["password"])) < 3){
      $password_err = "Parola 3 karakterden az olamaz.";
    }else{
      if($_POST["password"] !== $_POST["repassword"]){
        $password_err = "Parolalar uyuşmuyor.";
      }else{
        $password = $othersClass->control_input($_POST["password"]);
        $repassword = $othersClass->control_input($_POST["repassword"]);
      }
    }


    // control all errors
    if(empty($username_err) && empty($email_err) && empty($password_err)){
      // exists email
      if($usersClass->exits_email($email)){
        $error = "Böyle bir email kullanılmaktadır.";
      }

      // add user
      if(empty($error)){
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if($usersClass->addUser($username,$email,$password_hash)){
          $_SESSION["email"] = $email;
          $_SESSION["hash"] = $password_hash;

          header("Location: index");
          exit;
        }else{
          $error = "Kullanıcı ekleme hatası";
        }
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
          <h1 class="h3 text-center mb-5">Sign Up</h1>

          <!-- show error -->
          <?php if(!empty($error)): ?>
            <div class="alert alert-warning mb-3">
              <p class="mb-0"><?php echo $error; ?></p>
            </div>
          <?php endif; ?>  

          <a href="<?php echo $login_url; ?>" class="btn btn-danger w-100 mb-3">
            Sign Up with Google
          </a>

          <!-- sign up form -->
          <form method="POST" class="my-3">
            <!-- form username input -->
            <div class="form-group mb-3">
              <input type="text" class="form-control" name="username" placeholder="Username" 
                minlength="3" maxlength="15" required
                value="<?php echo $username; ?>"
                >
              <?php if(!empty($username_err)): ?>  
                <div class="text-danger">
                  <?php echo $username_err; ?> 
                </div>
              <?php endif; ?>  
            </div>
            
            <!-- form email input -->
            <div class="form-group mb-3">
              <input type="email" class="form-control" name="email" placeholder="Email" required
                value="<?php echo $email; ?>"
                >
              <?php if(!empty($email_err)): ?>  
                <div class="text-danger">
                  <?php echo $email_err; ?> 
                </div>
              <?php endif; ?>  
            </div>
            
            <!-- form password input -->
            <div class="form-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password" 
                minlength="3" required
                value="<?php echo $password; ?>"
                >
              <?php if(!empty($password_err)): ?>  
                <div class="text-danger">
                  <?php echo $password_err; ?> 
                </div>
              <?php endif; ?>  
            </div>
            
            <!-- form repassword input -->
            <div class="form-group mb-3">
              <input type="password" class="form-control" name="repassword" placeholder="Repassword" 
                minlength="3" required
                value="<?php echo $repassword; ?>"
                >  
            </div>

            <!-- sign up form submit button -->
            <div class="text-end">
              <button type="submit" name="signUp" class="btn btn-success">Sign Up</button>
            </div>
          </form>

          <div class="text-center">
            <span>Hesabınız var mı? <a href="login" class="link-primary">Giriş Yap</a></span>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
