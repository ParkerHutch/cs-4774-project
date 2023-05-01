<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PokeApp Home</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="/css/pokemon.css">
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="text-style.css">
  <!-- Pokemon Font -->
  <link href="https://fonts.googleapis.com/css?family=Pokemon" rel="stylesheet">
</head>
<body>
  <div class="container">
  <h1>Welcome to Poke<span class="app">App</span><img src="img/pokeball.png" alt="pokeball" width = 30 height =30 text-shadow='none'></h1>
    <div class="row">
      <div class="col-md-6">
        <img src="img/real-pikachu.gif" alt="Pikachu" class="img-fluid">
      </div>
      <div class="box">Welcome, trainers, to PokeApp - your ultimate companion in your quest to become the best! 
        <br><br> Here, you can dive into the world of Pokemon and experience the thrill of catching 'em all. With our Collecting Pokemon feature, you can handpick your favorite Pokemon and create a dream team to take on the toughest challenges.
<br><br>Our Gym View feature will guide you to gyms in your region and allow you to scope out their trainers. You can choose to join a gym or switch between them. With the Friend Groups Feature, you can create or join groups with other passionate trainers, explore their teams and progress, and interact with them.
<br><br>In our Trainer View, you can track your team's progress, change your region, and when you're on the hunt for new Pokemon to add to your team, our Pokemon Search View has got you covered. You can search, filter, and add new Pokemon to your team.
<br><br>Join us on this epic journey and become a master trainer in the world of Pokemon!<i></i></div>
    </div>
  <div class="center-on-page">
  <div class="container">
  <?php if (isset($_SESSION['user_id'])): ?>
  <?php else: ?>
  <div class="row justify-content-center">
  <h1>Please&nbsp;<a href="login-page.php">log in</a>&nbsp;or&nbsp;<a href="register.php">register</a>&nbsp;to continue</h1>
</div>
<?php endif; ?>
</div>
</div>
<br>
  <?php if (isset($_SESSION['user_id'])): ?>
  <div class="center-on-page">
  <div class="container">
    <div class="row justify-content-center">
    <div class="col-sm-3">
        <a href="trainer_profile.php">
        <h3>Trainer Profile</h3>
          <div class="pokeball">
          <div class="pokeball__button" href="trainer_profile.php"></div>
          </div>
        </a>
      </div>
      <div class="col-sm-3">
        <a href="all_pokemon.php">
        <h3>Pokemon Search</h3>
          <div class="pokeball">
          <div class="pokeball__button" href="all_pokemon.php"></div>
          </div>
        </a>
      </div>
      <div class="col-sm-3">
        <a href="gym_view.php">
        <h3 style="padding-left: 75px;">View<br>Gyms</h3>
          <div class="pokeball">
          <div class="pokeball__button" href="gym_view.php"></div>
          </div>
        </a>
      </div>
      <div class="col-sm-3">
        <a href="friend-groups.php">
          <h3>Friend<br>Groups</h3>
          <div class="pokeball">
          <div class="pokeball__button" href="friend-groups.php"></div>
          </div>
        </a>
      </div>
      <div class="col-sm-3">
        <a href="message-board.php">
          <h3>Message Board</h3>
          <div class="pokeball">
          <div class="pokeball__button" href="message-board.php"></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd