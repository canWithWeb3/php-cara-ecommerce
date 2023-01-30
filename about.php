<?php 
  require "admin/libs/functions.php"
?>

<?php require "views/_html-start.php"; ?>
<?php require "views/_navbar.php"; ?>


<main class="main-vh">
  
  <!-- top image -->
  <section style="background-image: url(img/about/banner.png);" class="page-banner positon-relative mb-5">
    <div class="d-flex justify-content-center align-items-center h-100 text-white">
      <div class="text-center">
        <h1 class="display-5 fw-bold mb-3">#Know Us</h1>
        <p style="font-size: 18px;">Lorem ipsum dolor sit amet consectetur.</p>
      </div>
    </div>
  </section>

  <section class="py-3 mb-5">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6">
          <img src="img/about/a6.jpg" alt="" class="img-fluid rounded">
        </div>

        <div class="col-lg-6">
          <div class="d-flex justify-content-center align-items-center h-100">
            <div>
              <h1 class="display-5 fw-bold mb-3">Who are We?</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi debitis tempore est ratione atque. Autem, voluptatibus debitis labore veniam voluptas consequuntur incidunt assumenda quis alias nobis, explicabo dolore adipisci ex id iusto voluptates sapiente illo numquam ut ipsa? Soluta, voluptas? Sequi, sit natus eveniet molestiae quas quibusdam odio, voluptate consequuntur reprehenderit unde obcaecati aspernatur aperiam.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container mb-5 pb-5">
    <div class="pb-3">
      <h1 class="fw-bold text-center mb-5">Download Our <span class="text-primary text-decoration-underline">App</span></h1>
      <div class="col-12 mx-auto">
        <video src="img/about/1.mp4" class="img-fluid rounded" autoplay muted loop></video>
      </div>
    </div>
  </section>
</main>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
