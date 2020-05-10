<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: plogin.php");
    exit;
}

// require_once "config.php";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Escape user inputs for security
$pid = $_POST['userid'];
$conpass = trim($_POST['confirm_password']);
$password = trim($_POST["password"]);
$pas =  password_hash($password, PASSWORD_DEFAULT);
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$adr1 = $_POST['addr1'];
$adr2 = $_POST['addr2'];
$adr3 = $_POST['addr3'];
$gender = $_POST['gender'];
$dept = $_POST['dep'];
$dob = $_POST['dob'];
$username = $_SESSION['username'];
require_once 'config.php';  
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
        $sql = "INSERT INTO `police`(`p_id`, `p_fname`, `p_lname`, `phone`, `addr_fline`, `addr_sline`, `addr_tline`, `dob`, `sex`, `d_id`) VALUES ($pid,'$fname','$lname',$phone,'$adr1','$adr2','$adr3','$dob', '$gender','$dept');";
        $user = "INSERT INTO `pusers`(`username`, `password`, `created_at`) VALUES ('$pid','$pas',CURRENT_TIME);";
        if(mysqli_query($link, $sql) && mysqli_query($link, $user)){
            echo "Records added successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
    mysqli_close($link); // close connection
}
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
        <div class="inner-card my-5">
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
                    <input type="text" name="dob" class="form-control" placeholder="DOB in YYYY-MM-DD format">
                </div>

                <div class="form-group text-dark">
                     Gender:<br>
                            <select class="form-control" name="gender" required="">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                            </select>
                </div>

                <div class="form-group text-dark">
                    Select Department:<br>
                    <select class="form-control" name="dep" required="">
                    <?php 
                        session_start();
                        require_once 'config.php';
                        $username =  $_SESSION['username'];
                        $querydropdown = "SELECT d_no, d_name from department where s_id in (select s_id from station where s_head = $username);";
                        $resultdropdown = mysqli_query($link, $querydropdown);
                        while ($row = mysqli_fetch_array($resultdropdown))
                        {
                              echo ' <option value="'.$row["d_no"].'">'.$row["d_no"].' '.$row["d_name"].'</option>';
                        }
                     ?>
                      </select>
                </div>

                <div class="input-group mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">

                    <div class="input-group-append">
                        <span class="input-group-text">
                        <i class="fa fa-eye-slash" id="hideme" onclick="showLoginPassword('hideme','inputPassword')" ></i></span>
                    </div>

                </div>
                <span class="help-block"></span>

                <div class="input-group mb-3">
                    <input type="password" id="inputPassword1" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-eye-slash" id="hideme1" onclick="showLoginPassword('hideme1','inputPassword1')"></i></span>
                        </div>
                </div>
                <span class="help-block"></span>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
    <<script type="text/javascript" src="bootstrap\js\jQuery.js"></script>
    <script type="text/javascript" src="bootstrap\js\bootstrap.bundle.js"></script>
    <script type="text/javascript" src="bootstrap\js\bootstrap.js"></script>
    <script type="text/javascript" src="js/register.js"></script>
</body>
</html>