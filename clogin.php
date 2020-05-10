  <?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect to dashboard.
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: complaintdashboard.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM cusers WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: complaintdashboard.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Form</title>
        <?php 
        include_once 'includes/header.php'
        ?>

        <!-- Custom css -->
        <link rel="stylesheet" href="css/stylelog.css">
    </head>
    <body>

        <!-- Navbar starts -->
        <?php 
        include_once 'includes/loginregisternavbar.php'; ?>
        <!-- Navbar ends -->

        <div class="wrapper">
            <div class="inner-card">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h2>Login</h2>
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>

                    <div class="input-group mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                        <span class="input-group-text"><i  id="hideme" class="fa fa-eye-slash" onclick="showLoginPassword('hideme', 'inputPassword')"></i></span>
                        </div>
                    </div>
                    <span class="help-block"><?php echo $password_err; ?></span>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>
