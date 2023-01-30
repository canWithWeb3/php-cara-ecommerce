<?php 
  require "admin/libs/functions.php";

  if($usersClass->isLogged()){
    header("Location: index");
    exit;
  }

  $email = $password = "";
  $rememberMe = 0;
  $email_err = $password_err = "";
  $error = "";

  // isset signIn
  if(isset($_POST["signIn"])){

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
      $password = $othersClass->control_input($_POST["password"]);
    }

    $rememberMe = isset($_POST["rememberMe"]) ? 1 : 0;

    // control all errors
    if(empty($email_err) && empty($password_err)){
      // exists email
      if(!$usersClass->exits_email($email)){
        $error = "Kullanıcı adı veya parola hatalı";
      }

      // add infos
      if(empty($error)){
        $user = $usersClass->getUserByEmail($email)->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $user["password"])){
          if($rememberMe){
            setcookie("email", $email, time() + 86400 * 28);
            setcookie("hash", $user["password"], time() + 86400 * 28);
          }else{
            $_SESSION["email"] = $email;
            $_SESSION["hash"] = $user["password"];
          }

          header("Location: index");
          exit;
        }else{
          $error = "Kullanıcı adı veya parola hatalı";
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
          <h1 class="h3 text-center mb-5">Sign In</h1>

          <!-- show error -->
          <?php if(!empty($error)): ?>
            <div class="alert alert-warning mb-3">
              <p class="mb-0"><?php echo $error; ?></p>
            </div>
          <?php endif; ?>  

          <!-- sign in form -->
          <form method="POST" class="my-3">
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
            <div class="form-group">
              <input type="password" class="form-control mb-2" name="password" placeholder="Password" 
                minlength="3" required
                value="<?php echo $password; ?>"
                >
                <?php if(!empty($password_err)): ?>  
                  <div class="text-danger">
                    <?php echo $password_err; ?> 
                  </div>
                <?php endif; ?>  

                <div class="d-flex justify-content-end">
                  <a href="forgot-password" class="d-inline-block link-primary">Şifreni mi unuttun?</a>
                </div>
            </div>

            <!-- form rememberMe input -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" 
                name="rememberMe" id="rememberMe"
                <?php if($rememberMe){ echo "checked"; } ?>
                >
              <label class="form-check-label" for="rememberMe">
                Remember Me
              </label>
            </div>

            <!-- sign up form submit button -->
            <div class="text-end">
              <button type="submit" name="signIn" class="btn btn-success">Sign In</button>
            </div>
          </form>

          <div class="text-center">
            <span>Hesabınız yok mu? <a href="register" class="link-primary">Kayıt Ol</a></span>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
