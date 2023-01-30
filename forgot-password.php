<?php 
  require "admin/libs/functions.php";

  if($usersClass->isLogged()){
    header("Location: index");
    exit;
  }

  $email = $password = "";
  $rememberMe = 0;
  $email_err = $password_err = "";
  $error = $success = "";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

  function sendResetPassword($email,$password_token){
    $mail = new PHPMailer(true);
  
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "";
    $mail->Password = "";
    $mail->SMTPSecure = "ssl"; // ssl tls seçildiğinde 587 seçmeliymişim.
    $mail->Port = 465; // 25, 465, 587
  
    $mail->setFrom("canoguzorhan066@gmail.com");  // $mail->SMTPKeepAlive = true;
  
    $mail->addAddress($email);
  
    $mail->isHTML(true);
    $mail->Subject = "Forgot Password";

    $mail->Body = "
    <div>
      <img src='img/logo.png' >
      <h1>Şifrenizi Yenileyin.<h1>
      <p style='font-size:18px; font-weight:normal;'>
        Cara web sitesine yapmış olduğunuz şifre yenileme mesajıdır. 
        Şifrenizi yenilemek için linke
        <a 
          href='http://localhost/cara/reset-password?email=$email&password_token=$password_token'>
          tıklayınız
        </a>
      <p>
    </div>  
    ";
  
    // $mail->addAttachment("");
    if($mail->send()){
      return true;
    }else{
      return false;
    }
  }


  // isset signIn
  if(isset($_POST["forgotPassword"])){

    // email validation
    if(empty(trim($_POST["email"]))){
      $email_err = "Email boş geçilemez.";
    }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $email_err = "Geçerli email giriniz.";
    }else{
      $email = $othersClass->control_input($_POST["email"]);
    }

    // control all errors
    if(empty($email_err)){
      // exists email
      if(!$usersClass->exits_email($email)){
        $error = "Bu email sistemimizde yok.";
      }

      // add infos
      if(empty($error)){
        $rand_token = openssl_random_pseudo_bytes(16);
        $password_token = bin2hex($rand_token);
        if($usersClass->changeUserPasswordTokenByEmail($email, $password_token)){
          if(sendResetPassword($email,$password_token)){
            $success = "Emailinize gelen linkten parolanızı yenileyebilirsiniz.";
          }else{
            $error = "Email gönderme hatası";
          }
        }else{
          $error = "Email gönderme hatası 3";
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
          <h1 class="h3 text-center mb-5">Forgot Password</h1>

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
            
            <!-- sign up form submit button -->
            <div class="text-end">
              <button type="submit" name="forgotPassword" class="btn btn-success">Send Email</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</main>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
