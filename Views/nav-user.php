<?php
  require_once("validate-session.php");
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="height: 10vh;">
  <div class="container"> 
    <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar12"> 
      <a class="navbar-brand d-none d-md-block" href="<?php echo FRONT_ROOT."Home/showHomeView"?>">
        <img  src="<?php echo IMG_PATH."nav-logo.png"?>" width="70" height="50">
        <b>MoviePass</b>
      </a>

      <ul class="navbar-nav mx-auto">
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Cinema/showListViewAll";?>">Cinemas</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Movie/showListView";?>">Movies</a> </li>
        <?php if ($_SESSION["type"] == "administrator") { ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Movie/showAddView";?>">Insert Movies</a> </li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Screening/showListViewOwner";?>">Screenings</a> </li>
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Revenue
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Ticket/soldTicketsMovieForm";?>">Revenue for Movie</a>
          <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Ticket/soldTicketsCinemaForm";?>">Revenue for Cinema</a>
      </li>

          <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Ticket/showListViewMoviesByOwner"; ?>">Tickets</a> </li>

        <?php } else { ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Screening/showListView";?>">Screenings</a> </li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Ticket/showListViewByUser"; ?>">Tickets</a> </li>
        <?php } ?>
      </ul>
      <ul class="navbar-nav">
        <li class="navbar-brand d-none d-md-block">Hello, <?php echo $_SESSION["userName"];?>! </li>
        <li class="nav-item"> <a class="nav-link text-primary" href="<?php echo  FRONT_ROOT."User/logout"?>">Log out</a> </li>
      </ul>
    </div>
  </div>
</nav>