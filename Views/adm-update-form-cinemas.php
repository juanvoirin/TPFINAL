<?php 
 include_once('header.php');
 include_once('nav-user.php');
?>
<div class="py-5 text-center" style="background-image: url('<?php echo IMG_PATH."background.jpg"?>');background-size:cover;">
  <div class="container">
    <div class="row">
      <div class="mx-auto col-md-8 col-10 bg-white p-5">
        <h1 class="mb-4 bg-primary text-white">Data Cinema<br></h1>
        <form action="<?php echo FRONT_ROOT ?>Cinema/updateCinema" method="post">
          <div class="form-group row">
            <label for="id" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">ID</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" readonly="readonly" placeholder="Id" name="id" id="id" value="<?php echo $cinema->getId();?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="id" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">NAME</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" placeholder="Name" name="name" id="name" value="<?php echo $cinema->getName();?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="id" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">ADDRESS</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" placeholder="Address" name="address" id="address" value="<?php echo $cinema->getAddress();?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="id" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">OWNER</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" readonly="readonly" placeholder="Owner" name="owner" id="owner" value="<?php echo $cinema->getOwner()->getName(); ?>">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Confirm<br></button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" style=""></script>