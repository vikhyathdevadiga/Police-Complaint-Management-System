<?php
session_start();
// Include config file
require_once "config.php";
 // Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Escape user inputs for security
$pid = mysqli_real_escape_string($link, $_REQUEST['userid']);
$password = mysqli_real_escape_string($link, $_REQUEST['password']);
$pas =  password_hash($password, PASSWORD_DEFAULT);

$username = $_SESSION['username'];

$ret=mysqli_query($link, "select `p_id` from `police` where `p_id`='$pid' ");
    $result=mysqli_fetch_array($ret);
    if($result>0){
        echo "<script type='text/javascript'>
                alert('This ID is  associated with another account');
            </script>";
// $msg="This email  associated with another account";
    }
    else{

// attempt insert query execution
$sql = "INSERT INTO `police`(`p_id`, `p_fname`, `p_lname`, `phone`, `addr_fline`, `addr_sline`, `addr_tline`, `dob`, `sex`, `d_id`) VALUES ($pid,[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10]);";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 }
}
// close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    
    <?php 
    include_once 'includes/header.php' ?>

    <!-- Custom css -->
    <link rel="stylesheet" href="css/stylelog.css">
</head>

<body>

    <div class="wrapper">
        <div class="inner-card">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2>Register Here</h2>

                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="userid" class="form-control" placeholder="UserID" >
                </div>

                <div class="form-group">
                <input type="text" name="fname" class="form-control" placeholder="First name" >
                </div>

                <div class="form-group">
                <input type="text" name="lname" class="form-control" placeholder="Last name" >
                </div>

                <div class="form-group">
                <input type="number" name="phone" class="form-control" placeholder=" Phone number" >
                </div>

                <div class="form-group">
                <input type="text" name="addr1" class="form-control" placeholder=" Address line 1" >
                </div>

                <div class="form-group">
                <input type="text" name="addr2" class="form-control" placeholder=" Address line 2" >
                </div>

                <div class="form-group">
                <input type="text" name="addr3" class="form-control" placeholder=" Address line 3" >
                </div>

                <div class="form-group">
                    <select class="form-control" name="gender" required="">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control" name="gender" required="">
                    <?php 
                    while ($row = mysqli_fetch_array($resultdropdown)) {
                    	echo ' <option value="'.$row["d_no"].'">'.$row["d_no"].' '.$row["d_name"].'</option>';
                    }
                    ?>
                    </select>
                </div>

                <div class="input-group mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" >

                    <div class="input-group-append">
                        <span class="input-group-text">
                        <i class="fa fa-eye-slash" id="hideme" onclick="showLoginPassword('hideme','inputPassword')" ></i></span>

                    </div>
                </div>
                <span class="help-block"></span>

                <div class="input-group mb-3 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" id="inputPassword1" name="confirm_password" class="form-control"  placeholder="Confirm Password">
                    <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-eye-slash" id="hideme1" onclick="showLoginPassword('hideme1','inputPassword1')"></i></span>
                    </div>
                </div>
                <span class="help-block"></span>
                <button type="submit" class="btn btn-primary">Register</button><a href="login1.php">Already have an account?</a>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="bootstrap\js\jQuery.js"></script>
    <script type="text/javascript" src="bootstrap\js\bootstrap.bundle.js"></script>
    <script type="text/javascript" src="bootstrap\js\bootstrap.js"></script>
    <script type="text/javascript" src="js/register.js"></script>

</body>
</html>
