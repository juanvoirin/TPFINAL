<?php   
include_once('header.php');
include_once('nav-user.php');
?>

<?php if(isset($message) && str_word_count($message) > 0){ ?>
  <div class="alert alert-danger text-center" role="alert" style="margin-bottom: 0;">
      <strong><?php echo $message; ?></strong>
  </div>
<?php } ?>
<div class="py-5 text-center" style="background-image: url('<?php echo IMG_PATH."background.jpg"?>'); background-size:cover;">
    <div class="container">
        <div class="row">
        <div class="mx-auto col-md-6 col-10 bg-white pb-3 pr-5 pl-5 pt-4">
        <h1 class="mb-4"><br>Revenue for Cinema</h1>
        <form action="<?php echo FRONT_ROOT ?>Ticket/soldTicketsByIdCinema" method="post">
          <div class="form-group row">
            <label for="id" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">Cinema</label>
            <div class="col-sm-9">
              <select class="form-control" id="idCinema" placeholder="idCinema" name="idCinema">
                  <?php foreach($cinemasList as $cinema){
                      if($_SESSION["loggedUser"] == $cinema->getOwner()->getEmail()){?>
                        <option value="<?php echo $cinema->getId();?>"><?php echo $cinema->getName(); ?></option>
                  <?php } } ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="Movie" class="font-weight-bolder bg-info text-black col-form-label col-sm-11">From Date:<div class="form-group"> <input type="date" class="form-control" placeholder="Date" name="date" id="date" required></div></label>
          </div>
          <div class="form-group row">
            <label for="Movie" class="font-weight-bolder bg-info text-black col-form-label col-sm-11">Until Date:<div class="form-group"> <input type="date" class="form-control" placeholder="Date" name="date2" id="date2" required></div></label>
          </div>
          <div class="card-body mx-auto">
            <button type="submit" class="btn btn-primary">Query<br></button>
          </div>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>