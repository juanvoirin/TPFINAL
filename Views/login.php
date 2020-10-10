<?php 
  include_once('header.php');
  include_once('nav-guest.php');
?>
<header>
  <title>Log in</title>
</header>
<div class="p-5 text-center" style="width:100%; background-image: url('<?php echo IMG_PATH."background.jpg"?>'); background-size:cover;">
  <div class="container">
    <div class="row">
      <div class="mx-auto col-md-6 col-10 bg-light p-3">
        <h1 class="mb-4">Log in</h1>
        <form action="<?php echo FRONT_ROOT."User/login" ?>" method="post">
          <div class="form-group">
            <label for="formInputEmail">Email address</label>
            <input type="email" class="form-control" placeholder="Enter email" name="email" id="formInputEmail">
          </div>
          <div class="form-group mb-3">
            <label for="formInputPassword">Passwrod</label>
            <input type="password" class="form-control" placeholder="Password" name="pass" id="formInputPassword">
          </div>
          <button type="submit" class="btn btn-primary" name="btnLogin">Sign in</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php
  include_once('footer.php');
?>