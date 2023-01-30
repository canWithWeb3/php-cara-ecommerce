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
        <h1 class="display-5 fw-bold mb-3">#let's_talk</h1>
        <p style="font-size: 18px;">LEAVE A MESSAGE, We love to hear from you!</p>
      </div>
    </div>
  </section>

  <section class="container">
    <div class="row g-5">
      <div class="col-lg-6">
        <div class="d-flex justify-content-center align-items-center h-100">
          <div class="d-flex flex-column">
            <p class="mb-2 text-secondary">GET IN TOUCH</p>
            <h1 class="fw-bold h3 mb-3">Visit one of our agency locations or contact us today</h1>
            <p class="fw-bold fs-5 mb-4">Head Office</p>

            <div class="d-flex flex-column gap-3">
              <div class="d-flex gap-3">
                <i class="fa-regular fa-map"></i>
                <span>56 Glassford Street Glasgow GI 1UL New York</span>
              </div>
              <div class="d-flex gap-3">
                <i class="fa-regular fa-envelope"></i>
                <span>canoguzorhan066@gmail.com</span>
              </div>
              <div class="d-flex gap-3">
                <i class="fa-solid fa-phone"></i>
                <span>0 532 488 37 72</span>
              </div>
            </div>
          </div>
        </div>  
      </div>

      <div class="col-lg-6">
        <iframe class="w-100 rounded" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9879.235932092055!2d-1.2543668!3d51.7548164!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd2ff1883a001afed!2sOxford%20%C3%9Cniversitesi!5e0!3m2!1str!2str!4v1673374883441!5m2!1str!2str" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>
</main>

<?php require "views/_footer.php"; ?>
<?php require "views/_html-finish.php"; ?>
