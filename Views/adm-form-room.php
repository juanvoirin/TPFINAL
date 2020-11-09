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
        <h1 class="mb-4">Data Room<br></h1>
        <form action="<?php echo FRONT_ROOT ?>Room/addRoom" method="post">
          <div class="form-group row">
            <label for="id" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">ID</label>
            <div class="col-sm-9">
              <select class="form-control" id="idCinema" readonly placeholder="idCinema" name="idCinema">
                <option value="<?php echo $cinema->getId();?>"><?php echo $cinema->getName(); ?></option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="id" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" placeholder="Name" name="name" id="name">
            </div>
          </div>
          <div class="form-group row">
            <label for="capacity" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">Capacity</label>
            <div class="col-sm-9">
              <input type="number" min="0" class="form-control" placeholder="Capacity" name="capacity" id="capacity">
            </div>
          </div>
          <div class="form-group row">
            <label for="ticketprice" class="font-weight-bolder bg-info text-black col-form-label col-sm-3">Ticket Price</label>
            <div class="col-sm-9">
              <input type="number" min="0" class="form-control" placeholder="TicketPrice" name="ticketprice" id="ticketprice">
            </div>
          </div>
          <div class ="m-3">
            <button type="submit" class="btn btn-primary">Add Room<br></button>
          </div>
          <div>
            <a href="<?php echo FRONT_ROOT."Room/showRooms?idCinema=".$cinema->getId();?>" class="btn btn-outline-secondary"><strong>Back To Form Date</strong></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
