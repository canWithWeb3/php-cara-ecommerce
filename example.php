

<?php 
  if(isset($_POST["addForm2"])){
    
  }
?>


<?php require "views/_html-start.php"; ?>

<form method="POST">
  <input type="text" class="d-none" name="can2" value="<b>ca</b>"></input>
  <button type="submit" name="addForm2" class="btn btn-primary">Gönder</button>
</form>

<!-- <div class="container my-5">
  <div class="card">
    <div class="card-header">Form</div>
    <div class="card-body">
      <form method="POST">
        <div id="input" class="form-check mb-3">
          <input onclick="takeMyAddressFunction(this)" class="form-check-input" type="checkbox" value="" name="takeMyAddress" id="takeMyAddress">
          <label class="form-check-label" for="takeMyAddress">
            Adresimden al
          </label>
        </div>

        <div id="textarea" class="mb-3">
          <div class="form-label">Adres:</div>
          <textarea name="address" rows="5" class="form-control"></textarea>
        </div>

        <button type="submit" name="addForm" class="btn btn-primary">Gönder</button>
      </form>
    </div>
  </div>
</div> -->


<script>
  $(document).ready(function(){
    $("#textarea").fadeOut(200);
  })

  function takeMyAddressFunction(e){
    if(e.checked){
      $("#textarea").fadeIn(200);
    }else{
      $("#textarea").fadeOut(200);
    }
  }
</script>

<?php require "views/_html-finish.php"; ?>