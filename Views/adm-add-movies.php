<?php
 include_once('header.php');
 include_once('nav-user.php');
?>
<div class="pt-5 pb-1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Movies available to add<br></h1>
        <!-- <h5 class="">Sort by</h5>
        <div class="btn-group">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Date</button>
          <div class="dropdown-menu">
            <form action="<?php //echo FRONT_ROOT ?>Movie/showListByDate" method="GET" class="dropdown-item">
              <div class="form-group"> <input type="date" class="form-control" placeholder="Date" name="date" id="date"></div>
              <button type="submit" class="btn btn-secondary btn-block">Go<br></button>
            </form>
          </div>
        </div>
        <div class="btn-group">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Genre</button>
          <div class="dropdown-menu"> 
            /*<?php /*
            foreach($genreList as $genre) { */?>
            <a class="dropdown-item" href="<?php //echo FRONT_ROOT."Movie/showListByGenre?idGenre=".$genre->getId();?>"><?php // echo $genre->getName(); ?><br></a>
            <?php //} ?>
          </div>
        </div>
      </div>--> 
    </div>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="row">
      <?php foreach($movieList as $movie) { ?>
      <div class="col-md-4 mb-5">
        <div class="card">
          <img class="card-img-top" src="<?php echo $movie->getPoster_path(); ?>" alt="Card image cap">
          <div class="card-body mx-auto">
            <h5 class="card-title font-weight-bold"><?php echo $movie->getTitle(); ?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Overview: <?php echo $movie->getOverview(); ?></li>
            <li class="list-group-item">Género: <?php echo $movie->getGenresString(); ?></li>
            <li class="list-group-item">Original Language: <?php echo $movie->getOriginal_language(); ?> </li>
            <li class="list-group-item">Release Date: <?php echo $movie->getRelease_date(); ?> </li>
            <li class="list-group-item">Runtime: <?php echo $movie->getRuntime();  ?> min. </li>
          </ul>
          <?php if($_SESSION["type"]== "administrator"){  ?>
          <div class="card-body mx-auto">
            <a href="<?php echo  FRONT_ROOT."Screening/showFormScreening?idMovie=".$movie->getID(); ?>"> 
              <button href="details-purchase.php" class="btn btn-primary">Add</button> 
            </a>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php
  include_once('footer.php');
?>