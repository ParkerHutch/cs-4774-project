<?php include('header.php'); ?>
<?php
// Start session
session_start();

// Check if user is logged in, redirect to login page if false
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] !== true) {
    header("location: login.php");
    exit;
}

// Include database connection file
require_once "connect-db.php";

// Define variables and initialize with session values
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$username_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            // Update user's email in database
                            $sql = "UPDATE users SET email = :email WHERE id = :id";

                            if ($stmt = $pdo->prepare($sql)) {
                                // Bind variables to the prepared statement as parameters
                                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                                $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

                                // Set parameters
                                $param_email = $email;
                                $param_id = $id;

                                // Attempt to execute the prepared statement
                                if ($stmt->execute()) {
                                    // Update session variable with new email
                                    $_SESSION["email"] = $email;

                                    // Redirect user to user page with success message
                                    header("location: user.php?success=1");
                                } else {
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                unset($stmt);
                            }
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">User Information</h1>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" required>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
