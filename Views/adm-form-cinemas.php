<?php 
 include_once('header.php');
 include_once('nav-guest.php');
?>
<div class="py-5 text-center" style="background-image: url('<?php echo IMG_PATH."background.jpg"?>');background-size:cover;">
  <div class="container">
    <div class="row">
      <div class="mx-auto col-md-6 col-10 bg-white p-5">
        <h1 class="mb-4">Data Cinema<br></h1>
        <form action="<?php echo FRONT_ROOT ?>Cinema/addCinema" method="post">
          <div class="form-group"> <input type="text" class="form-control" placeholder="Name" name="name" id="name"> </div>
          <div class="form-group"> <input type="number" class="form-control" placeholder="Capacity" name="capacity" id="capacity"> </div>
          <div class="form-group"> <input type="text" class="form-control" placeholder="Address" name="address" id="address"> </div>
          <div class="form-group"> <input type="text" class="form-control" placeholder="$ Price" name="price" id="price"> </div>
          <button type="submit" class="btn btn-primary">Sign up<br></button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" style=""></script>