<?php 
  require_once("validate-session.php");
  include_once('header.php');
  include_once('nav-user.php');
?>

<div class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Cinemas</h1>
      </div>
    </div>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Cinema Name</th>
                <th>Capacity</th>
                <th>Address</th>
                <th>Ticket Price</th>
                <th>Owner</th>
                <?php if($_SESSION["type"] == "administrator") { ?>
                <th style="text-align: center">  </th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 0;
              foreach($cinemasList as $cinema) {
                $count++;
              ?>
              <tr>
                <th style="vertical-align: middle"><?php echo $count; ?></th>
                <td style="vertical-align: middle"><?php echo $cinema->getName(); ?></td>
                <td style="vertical-align: middle"><?php echo $cinema->getCapacity(); ?></td>
                <td style="vertical-align: middle"><?php echo $cinema->getAddress(); ?></td>
                <td style="vertical-align: middle"><?php echo $cinema->getPrice(); ?></td>
                <td style="vertical-align: middle"><?php echo $cinema->getOwner(); ?></td>
                <?php if($_SESSION["type"] == "administrator") { ?>
                  <td style="text-align: center">
                    <a href="<?php echo FRONT_ROOT."Cinema/delete?id=".$cinema->getId();?>">
                      <button small type="submit" class="btn btn-primary"  value="<?php echo $cinema->getId(); ?>">Eliminar</button>
                    </a>
                  </td>
                <?php } } ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!--<?php //if($_SESSION["type"] == "administrator") { ?>


  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Add Cinema</h1>
      </div>
    </div>
  </div>

<form action="<?php //echo FRONT_ROOT."Cinema/addCinema"; ?>" method="post">
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-2"> <input type="text" class="form-control" placeholder="Cinema name" name="name" id="name"> </div>
        <div class="col-md-2"> <input type="number" class="form-control" placeholder="Total capacity" name="capacity" id="capacity"> </div>
        <div class="col-md-2"> <input type="text" class="form-control" placeholder="Address" name="address" id="address"> </div>
        <div class="col-md-2"> <input type="number" class="form-control" placeholder="Ticket price" name="price" id="price"> </div>
        <div class="col-md-2"> <button type="submit" class="btn btn-primary">Add</button></div>
      </div>
    </div>
  </div>
</form>

<div class="mt-5">
</div>

<?php //} ?>-->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>