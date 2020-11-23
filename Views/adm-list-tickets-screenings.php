<?php 
  include_once('header.php');
  include_once('nav-user.php');
?>

<?php if(isset($message) && str_word_count($message) > 0){ ?>
  <div class="alert alert-warning text-center" role="alert" style="margin-bottom: 0;">
      <strong><?php echo $message; ?></strong>
  </div>
<?php } ?>
<div class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Tickets</h1>
      </div>
    </div>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="mb-2">
      <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator") { ?>
          <a href="<?php echo FRONT_ROOT."Ticket/showListViewMoviesByOwner";?>" class="btn btn-outline-success">Movies</a>
          <a href="<?php echo FRONT_ROOT."Ticket/showListViewScreeningsByOwner";?>" class="btn btn-success disabled">Screenings</a>
          <a href="<?php echo FRONT_ROOT."Ticket/showListViewCinemasByOwner";?>" class="btn btn-outline-success">Cinemas</a>
      <?php } ?>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead class="thead-dark">
              <tr>
                <th style="text-align: center">#</th>
                <th style="text-align: center">Movie</th>
                <th style="text-align: center">Date</th>
                <th style="text-align: center">Time</th>
                <th style="text-align: center">Cinema</th>
                <th style="text-align: center">Room</th>
                <th style="text-align: center">Sold</th>
                <th style="text-align: center">Remaining</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 0;
              foreach($list as $screening) {
                $count++;
              ?>
              <tr>
                <th style="vertical-align: middle"><?php echo $count; ?></th>
                <td style="vertical-align: middle"><?php echo $screening->getMovie()->getTitle(); ?></td>
                <td style="vertical-align: middle"><?php echo $screening->getDate(); ?></td>
                <td style="vertical-align: middle"><?php echo $screening->getTime(); ?> Hs</td>
                <td style="vertical-align: middle"><?php echo $screening->getRoom()->getCinema()->getName(); ?></td>
                <td style="vertical-align: middle"><?php echo $screening->getRoom()->getName(); ?></td>
                <td style="vertical-align: middle"><?php echo $screening->getSold(); ?></td>
                <td style="vertical-align: middle"><?php echo ($screening->getRoom()->getCapacity() - $screening->getSold()); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>