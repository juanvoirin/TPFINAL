<?php 
  include_once('header.php');
  if(!isset($_SESSION["type"])){
    include_once('nav-guest.php');
   }else{
    include_once('nav-user.php');
  }
?>

<?php if(str_word_count($message) > 0){ ?>
  <div class="alert alert-warning" role="alert" style="margin-bottom: 0;">
      <strong><?php echo $message; ?></strong>
  </div>
<?php } ?>
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
    <div class="mb-2">
      <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator") { ?>
        <?php if($all == true){ ?>
          <a href="<?php echo FRONT_ROOT."Cinema/showListViewByOwner";?>" class="btn btn-outline-success">See mine</a>
          <a href="<?php echo FRONT_ROOT."Cinema/showListViewAll";?>" class="btn btn-success disabled">See all</a>
        <?php }else { ?>
          <a href="<?php echo FRONT_ROOT."Cinema/showListViewByOwner";?>" class="btn btn-success disabled">See mine</a>
          <a href="<?php echo FRONT_ROOT."Cinema/showListViewAll";?>" class="btn btn-outline-success">See all</a>
      <?php } } ?>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead class="thead-dark">
              <tr>
                <th style="text-align: center">#</th>
                <th style="text-align: center">Cinema Name</th>
                <th style="text-align: center">Address</th>
                <th style="text-align: center">Owner</th>
                <th style="text-align: center">Rooms</th>
                <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator") { ?>
                <th style="text-align: center">Delete</th>
                <th style="text-align: center">Update</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 0;
              foreach($cinemasListAll as $cinema) {
                $count++;
              ?>
              <tr>
                <th style="vertical-align: middle"><?php echo $count; ?></th>
                <td style="vertical-align: middle"><?php echo $cinema->getName(); ?></td>
                <td style="vertical-align: middle"><?php echo $cinema->getAddress(); ?></td>
                <td style="vertical-align: middle"><?php echo $cinema->getOwner()->getName(); ?></td>
                <td style="text-align: center">
                  <a href="<?php echo FRONT_ROOT."Room/showRooms?id=".$cinema->getId();?>" class="btn btn-primary">Rooms</a>
                </td>
                <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator") { ?>
                <td style="text-align: center">
                  <?php if($_SESSION["loggedUser"] == $cinema->getOwner()->getEmail()){ ?>
                    <a href="<?php echo FRONT_ROOT."Cinema/deleteCinema?id=".$cinema->getId();?>" class="btn btn-danger">Delete</a>
                  <?php } ?>
                </td>
                <td style="text-align: center">
                  <?php if($_SESSION["loggedUser"] == $cinema->getOwner()->getEmail()){ ?>
                    <a href="<?php echo FRONT_ROOT."Cinema/updateToFormCinema?id=".$cinema->getId();?>" class="btn btn-warning">Update</a>
                  <?php } ?>
                </td>
                <?php } ?>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator") { ?>
            <a href="<?php echo FRONT_ROOT."Cinema/addCinemaForm";?>" class="btn btn-primary btn-lg btn-block">Add</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>