<?php include('header.php'); ?>
<?php include('login.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Form</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="text-style2.css">
  <link rel="stylesheet" href="pokemon.css">
  <link rel="stylesheet" href="form.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <?php if (isset($errorMessage)): ?>
              <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form method="post">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control <?php echo !empty($usernameErr) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" required>
                <?php if ($username_err): ?>
                  <div class="invalid-feedback"><?php echo $usernameErr; ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control <?php echo !empty($passwordErr) ? 'is-invalid' : ''; ?>" required>
                <?php if ($username_err): ?>
                  <div class="invalid-feedback"><?php echo $passwordErr; ?></div>
                <?php endif; ?>
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
			<p>Don't have an account yet? <a href="register.php">Register here</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
				
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+X6QL9UvYjZE5yicNYzEgM6IpZxy/n" crossorigin="anonymous"></script>
</body>
</html>

