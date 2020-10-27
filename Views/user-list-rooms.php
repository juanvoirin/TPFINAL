<?php 
  require_once("validate-session.php");
  include_once('header.php');
  include_once('nav-user.php');
?>

<div class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Rooms of <?php echo $cinema->getName() ?></h1>
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
                <th>Room Name</th>
                <th>Capacity</th>
                <th>Ticket Price</th>
                <?php if($_SESSION["type"] == "administrator") { ?>
                <th style="text-align: center">Delete</th>
                <th style="text-align: center">Update</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 0;
              foreach($roomList as $room) {
                $count++;
              ?>
              <tr>
                <th style="vertical-align: middle"><?php echo $count; ?></th>
                <td style="vertical-align: middle"><?php echo $room->getName(); ?></td>
                <td style="vertical-align: middle"><?php echo $room->getCapacity(); ?></td>
                <td style="vertical-align: middle"><?php echo $room->getPrice(); ?></td>
                <td style="text-align: center">
                  <?php { ?>
                    <a href="<?php echo FRONT_ROOT."Room/deleteRoom?id=".$room->getId();?>" class="btn btn-danger">Delete</a>
                  <?php } ?>
                </td>
                <td style="text-align: center">
                <?php { ?>
                    <a href="<?php echo FRONT_ROOT."Room/deleteRoom?id=".$room->getId();?>" class="btn btn-warning">Update</a>
                  <?php } } ?>
                </td>
              </tr>
            </tbody>
          </table>
          <?php if($_SESSION["type"] == "administrator") { ?>
            <a href="<?php echo FRONT_ROOT."Room/showAddRoom?idCinema=".$cinema->getId();?>" class="btn btn-primary btn-lg btn-block">Add</a>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>