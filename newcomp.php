<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: clogin.php");
    exit;
}
// Include config file
require_once "config.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
$username = $_SESSION['username'];
$query =  "SELECT MAX(reg_id) as maximum from comp_reg";

$name = $_POST['name'];
$phoneno = $_POST['phoneno'];
$description = $_POST['description'];

$result = mysqli_query($link,$query);
$row = mysqli_fetch_assoc($result);
$max = $row['maximum'];
$max = $max + 1;

$query1 = "SELECT distinct p.p_id as p_id from department d,police p where d.d_no= p.d_id and d.registerer_id = $username";
$res1=mysqli_query($link, $query1);
$count=0;
while($row = mysqli_fetch_array($res1)){
            // echo "<tr>";
	$pids[$count] = $row['p_id'];
            $count = $count + 1;
        }
// echo $row1['p_id'];
$rand_keys = array_rand($pids);
echo $pids[$rand_keys];

// attempt insert query execution
$sql = "INSERT INTO comp_reg (reg_id, complainer_name, c_phone, c_date, c_descrip, registerer_id, assnd_to) VALUES ('$max', '$name', $phoneno, CURRENT_TIMESTAMP,'$description','$username', $pids[$rand_keys] )";
if(mysqli_query($link, $sql)){
    echo "<script type='text/javascript'>
                alert('Complaint Registered successfully!');
            </script>";
} else{
    echo "<script type='text/javascript'>
                alert('Unable to register! Please try again.');
            </script>";}
 }
// close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
	
    <title>Register New Complaint</title>

	<?php 
    include_once 'includes/header.php' ?>

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="css/styleadmin.css">
</head>
<body>

    <!--creating navbar-->
    <?php 
    include_once 'includes/policenavbar.php' ?>
    <!-- navbar ends-->

    <!--sidebar starts-->
    <?php 
    include_once 'includes/registersidebar.php' ?>
    <!--sidebar ends-->

    <!--Main body-->
    <div id="main">
        <h3 id="boys">Register New Complaint</h3>
            <form method="POST">
                <div class="container">
                    <div class="form-group">
                        <!--Complaint Registry-->
                        Complainer Name:<br>
                        <input type="text"  class="form-control"  name="name" placeholder="Enter Name" ><br>

                        Phone number:<br>
                        <input type="number" class="form-control" name="phoneno" placeholder="Enter phone number" ><br>

                        Location:<br>
                        <input type="text"  class="form-control"  name="location" placeholder="Enter location" ><br>

                        Date:<br>
                        <input type="text" class="form-control"  name="date" placeholder="mm-dd-yyyy"><br>

                        Description:<br>
                        <textarea cols="50" class="form-control" name="description" rows="5"></textarea>  
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
    </div>
    <!--Main body ends-->
</body>
</html>