<?php include('header.php'); ?>
<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
/*
if (session_status() == PHP_SESSION_ACTIVE) {
  echo "Session has started";
} else {
  echo "Session has not started";
}
*/
  require_once('connect-db.php');

  $username = $email = $password = '';
  $username_err = $email_err = $password_err = '';

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if(empty(trim($_POST['username']))) {
      $username_err = 'Please enter a username.';
    } else {
      $sql = 'SELECT id FROM users WHERE username = ?';

      if($stmt = $db->prepare($sql)) {
        $stmt->bindParam(1, $param_username, PDO::PARAM_STR);

        $param_username = trim($_POST['username']);

        if($stmt->execute()) {
          if($stmt->rowCount() == 1) {
            $username_err = 'This username is already taken.';
          } else {
            $username = $param_username;
          }
        } else {
          echo 'Oops! Something went wrong. Please try again later.';
        }

        unset($stmt);
      }
    }

    // Validate email
    if(empty(trim($_POST['email']))) {
      $email_err = 'Please enter an email address.';
    } else {
      $sql = 'SELECT id FROM users WHERE email = ?';

      if($stmt = $db->prepare($sql)) {
        $stmt->bindParam(1, $param_email, PDO::PARAM_STR);

        $param_email = trim($_POST['email']);

        if($stmt->execute()) {
          if($stmt->rowCount() == 1) {
            $email_err = 'This email address is already registered.';
          } else {
            $email = $param_email;
          }
        } else {
          echo 'Oops! Something went wrong. Please try again later.';
        }

        unset($stmt);
      }
    }

    // Validate password
    if(empty(trim($_POST['password']))) {
      $password_err = 'Please enter a password.';
    } elseif(strlen(trim($_POST['password'])) < 6) {
      $password_err = 'Password must have at least 6 characters.';
    } else {
      $password = trim($_POST['password']);
    }

    // Insert data into database
    if(empty($username_err) && empty($email_err) && empty($password_err)) {
      $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';

      if($stmt = $db->prepare($sql)) {
        $stmt->bindParam(1, $param_username, PDO::PARAM_STR);
        $stmt->bindParam(2, $param_email, PDO::PARAM_STR);
        $stmt->bindParam(3, $param_password, PDO::PARAM_STR);

        $param_username = $username;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        if($stmt->execute()) {
          header('location: home.php');
        } else {
          echo 'Oops! Something went wrong. Please try again later.';
        }

        unset($stmt);
      }
    }

    unset($db);
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
    <link rel="stylesheet" href="text-style2.css">
    <link rel="stylesheet" href="css/pokemon.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
	<div class="container my-5">
		<div class="card mx-auto" style="max-width: 400px;">
			<div class="card-header">Registration</div>
			<div class="card-body">
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<div class="form-group">
						<label for="username">Username:</label>
						<input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
						<span class="invalid-feedback"><?php echo $username_err; ?></span>
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
						<span class="invalid-feedback"><?php echo $email_err; ?></span>
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
						<span class="invalid-feedback"><?php echo $password_err; ?></span>
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm Password:</label>
						<input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="">
						<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Register">
						<input type="reset" class="btn btn-secondary ml-2" value="Reset">
					</div>
					<p>Already have an account?<br> <a href="login-page.php">Login here</a>.</p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
