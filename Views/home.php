<?php 
 include_once('header.php');
 include_once('nav-user.php');
 require_once("validate-session.php");
?>
<div class="pt-5 pb-1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Movies in theaters now<br></h1>
        <h5 class="">Sort by</h5>
        <div class="btn-group">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Date</button>
          <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Movie/showListNewest";?>">Newest</a>
          <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Movie/showListOldest";?>">Oldest<br></a>
          </div>
        </div>
        <div class="btn-group">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Genre</button>
          <div class="dropdown-menu"> 
            <?php
            foreach($genreList as $genre) { ?>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT."Movie/showListByGenre?idGenre=".$genre->getId();?>"><?php echo $genre->getName(); ?><br></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="row">
      <?php foreach($movieList as $movie) { ?> <!-- Comienzo de tarjeta -->
      <div class="col-md-4 mb-5" style="">
        <div class="card">
          <img class="card-img-top" src="<?php echo $movie->getImage(); ?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
            <p class="card-text"><?php echo $movie->getDescription(); ?></p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Género: <?php echo $movie->genresToString(); ?> </li>
          </ul>
          <div class="card-body mx-auto">
            <?php if ($_SESSION["isAdmin"] == 1) { ?>
              <a href="<?php echo  FRONT_ROOT."Screening/deleteMovie?idMovie=".$movie->getID(); ?>"> 
                <button href="details-purchase.php" class="btn btn-primary">Eliminar</button> 
              </a>
            <?php } else { ?>
            <a href="<?php echo  FRONT_ROOT."Screening/showScreeningDetails?idMovie=".$movie->getID(); ?>"> 
              <button href="details-purchase.php" class="btn btn-primary">Buy tickets!</button> 
            </a>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?> <!-- Final de la tarjeta -->
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>