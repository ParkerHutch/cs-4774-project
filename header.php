<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your App Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\form.css">  
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<!-- Image and text -->
<body>
<nav class="navbar navbar-default navbar-expand-lg navbar-light">
<a class="navbar-brand" href="home.php">
    <div class="row align-items-center">
      <div class="col">
        Poke<b>App</b>
      </div>
      <div class="col">
        <img src="img\pokeball.png" alt="Logo" width = 20 height = 20>
      </div>
    </div>
  </a>
	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse">
		<ul class="navbar-nav ml-auto">
      <?php if (isset($_SESSION['user_id'])): ?>
      <li><a href="trainer_profile.php">Trainer Profile</a></li>	
			<li><a href="all_pokemon.php">Pokemon Search</a></li>
      <li><a href="gym_view.php">View Gyms</a></li>
      <li><a href="friend_groups.php">Friend Groups</a></li>		
      <?php endif; ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-user-o"></i>&nbsp;<?php echo $_SESSION['username']; ?></a>
        <ul class="dropdown-menu login-dd" aria-labelledby="dropdownMenuButton1">
          <!--<li><a class="dropdown-item" href="#">My Account</a></li>-->
          <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
        </ul>
      <?php else: ?>
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-user-o"></i> Login</a>
				<ul class="dropdown-menu">
					<li>
              <form class="form-inline login-form" action="login.php" method="post">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" name="username" class="form-control <?php echo !empty($usernameErr) ? 'is-invalid' : ''; ?>"  required>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="password" name="password" class="form-control <?php echo !empty($passwordErr) ? 'is-invalid' : ''; ?>" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Login</button>
                  <p>Don't have an account? <a href="register.php" style="color: #0275d8 !important">Register here</a></p>
                </form>                        
					</li>
				</ul>
			</li>
      <?php endif; ?>
		</ul>
    </ul
	</div>
</nav>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>


<footer class="text-center text-white fixed-bottom" style="background-color: gray;">
<p style="font-size: 15px">A CS 4750 Project</p>
</footer>