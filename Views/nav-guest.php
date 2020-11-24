<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="height: 10vh;">
  <div class="container"> 
    <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar12"> 
      <a class="navbar-brand d-none d-md-block" href="<?php echo FRONT_ROOT."Home/showHomeView "?>">
        <img  src="<?php echo IMG_PATH."nav-logo.png"?>" width="70" height="50">
        <b>MoviePass</b>
      </a>
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Cinema/showListViewAll";?>">Cinemas</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Screening/showListView";?>">Screenings</a> </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"> <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/showLoginView "?>">Log in</a> </li>
        <li class="nav-item"> <a class="nav-link text-primary" href="<?php echo  FRONT_ROOT."Home/showRegisterView "?>">Register</a> </li>
      </ul>
    </div>
  </div>
</nav>