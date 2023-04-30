<html>
   <body>
      <a href="all_pokemon.php">See all pokemon</a>
      <a href="queries.php">queries.php</a>
      <a href="query.php">query.php</a>
      <a href="trainers.php">Trainers</a>
      <a href="trainer_profile.php">Trainer Profile</a>
      <a href="friend-groups.php">Friend Groups</a>
      <a href="message-board.php">Message Board</a>
   </body>
</html>
<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
   case '/':                   // URL (without file name) to a default screen
      require 'all_pokemon.php';
      break; 
   case '/home.php':
      require 'home.php';
      break;
   case '/login-page.php':
      require 'login-page.php';
      break;
   case '/gym-view.php':
      require 'gym-view.php';
      break;
   case '/pokemon-team.php':
      require 'pokemon-team.php';
      break;
   case '/friend-groups.php':
      require 'friend-groups.php';
      break;
   case '/pokemon-detail-view.php':
      require 'pokemon-detail-view.php';
      break;
   case '/message-board.php':
      require 'message-board.php';
      break;
   case '/login.php':
      require 'login.php';
      break;
   case '/logout.php':
      require 'logout.php';
      break;
   case '/register.php':
      require 'register.php';
      break;
   case '/all_pokemon.php':
      require 'all_pokemon.php';
      break;
   case '/trainers.php':
      require 'trainers.php';
      break;
   case '/trainer_profile.php':
      require 'trainer_profile.php';
      break;
   case '/test.php':
      require 'test.php';
      break;
   case '/simpleform.php':     // if you plan to also allow a URL with the file name 
      require 'simpleform.php';
      break;              
   case '/contact.php':
      require 'contact.php';
      break;
   case '/query.php':
      require 'query.php';
      break;
   case '/queries.php':
      require 'queries.php';
      break;
   case 'connect-db.php':
      require 'connect-db.php';
      break;
   default:
      http_response_code(404);
      exit('Not Found');
}  
?>