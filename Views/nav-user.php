<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container"> 
    <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar12"> 
      <a class="navbar-brand d-none d-md-block" href="<?php echo FRONT_ROOT."Home/showHomeView"?>">
        <i class="fa d-inline fa-lg fa-circle"></i>
        <b>MoviePass</b>
      </a>

      <ul class="navbar-nav mx-auto">
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Cinema/showListView";?>">Cinemas</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Movie/showListView";?>">Movies</a> </li>
        <?php if ($_SESSION["type"] == "administrator") { ?>
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Movie/showListView";?>">Insert Movies</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Screening/showListView";?>">Screenings</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Purchase/showRevenueView";?>">Revenue</a> </li>
        <?php } else { ?>
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Purchase/showListView";?>">Tickets bought</a> </li>
        <?php } ?>
      </ul>
      <ul class="navbar-nav">
        <li class="navbar-brand d-none d-md-block">Hello, <?php echo $_SESSION["userName"];?>! </li>
        <li class="nav-item"> <a class="nav-link text-primary" href="<?php echo  FRONT_ROOT."User/logout"?>">Log out</a> </li>
      </ul>
    </div>
  </div>
</nav>