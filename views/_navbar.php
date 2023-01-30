<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $host; ?>/index"><img src="<?php echo $host; ?>/img/logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-lg-0">
        <?php if($usersClass->isAdmin()): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $host; ?>/admin/admin">Admin</a>
          </li>
        <?php endif; ?>  

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $host; ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $host; ?>/shop">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link position-relative" href="<?php echo $host; ?>/cart">
            <span id="loggedId" class="d-none">
              <?php 
                if($usersClass->isLogged()){
                  $logged = $usersClass->getLogged()->fetch(PDO::FETCH_ASSOC);
                  echo $logged["id"];
                }
              ?>
            </span>
            <i class="fa-solid fa-bag-shopping fs-5"></i>
            <span class="navbarCartCount position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger">
              0
            </span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user fs-5"></i>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if($usersClass->isLogged()): ?>
              <li><a class="dropdown-item" href="logout">Logout</a></li>
            <?php else: ?>  
              <li><a class="dropdown-item" href="login">Sign In</a></li>
              <li><a class="dropdown-item" href="register">Sign Up</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  function getNavbarCartCount(){
    const loggedId = document.getElementById("loggedId").innerHTML;
    const navbarCartCount = document.querySelector(".navbarCartCount");
    $.ajax({
      url: "<?php echo $host."/post/getUserCartCount.php"; ?>",
      type: "POST",
      data: {
        loggedId: loggedId
      },
      success: function(res){
        navbarCartCount.textContent = res;
      },
      error: function(){
        console.log("error");
      }
    })
  }

  $(document).ready(function(e){
    getNavbarCartCount();
  })
</script>