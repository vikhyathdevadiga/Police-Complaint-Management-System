<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: plogin.php");
    exit;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

if(isset($_POST['submitted']))
    {
        $l_id  = $_POST["lid"];
        $_SESSION["lid"] = $l_id;
        session_start(); 
        header("location: solvedcomp.php");
    }
// close connection
mysqli_close($link);

}
$username = $_SESSION['username'];
$sqlStr = "SELECT * from comp_reg c where assnd_to = $username and reg_id not in (select reg_id from issolved ) 
";
$result = mysqli_query($link, $sqlStr);
$count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Assignments</title>
	

    <?php 
    include_once 'includes/header.php' ?>

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="css/styleadmin.css">
    
</head>
<body>

    <!-- Navbar starts -->
    <?php 
    include_once 'includes/policenavbar.php' ?> 
    <!-- navbar ends-->
    	
    <!--sidebar starts-->
    <?php 
    include_once 'includes/policesidebar.php' ?>
    <!--sidebar ends-->

    <!--Main body-->
    <div id="main">
    <?php
    echo'<div class="limiter">
            <div class="container-table100">';  
            if(!($result) || mysqli_num_rows($result)==0)
            {
                echo '<h4 class = "text-white">No Assignments found!</h4>';
            }
            else{
                echo'<div class="wrap-table100">
                        <div class="table100">
                            <table>
                                <thead>
                                    <tr class="table100-head">
                                        <th class="column4">Complaint ID</th>
                                        <th class="column4">Complainer Name</th>
                                        <th class="column4">Phone number</th>
                                        <th class="column4">Registration date</th>
                                        <th class="column4">Description</th>
                                        <th class="column4">Registrer ID</th>
                                        <th class="column4">Is Solved</th>
                                    </tr>
                                </thead>';
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                echo '
                                    <tr>
                                        <td class="column4">'.$row['reg_id'].'</td>
                                        <td class="column4">'.$row['complainer_name'].'</td>
                                        <td class="column4">'.$row['c_phone'].'</td>
                                        <td class="column4">'.$row['c_date'].'</td>
                                        <td class="column4">'.$row['c_descrip'].'</td>
                                        <td class="column4">'.$row['registerer_id'].'</td>
                                        <form method = "POST">
                                            <input type="hidden" name = "lid" value = '.$row['reg_id'].' class="btn btn-primary">

                                            <td class="column4"><button name = "submitted" type="submit" class="btn btn-success">Solved</button></td>
                                        </form>
                                    </tr>';
                                }
                                echo '</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>';
        }
    ?>
    </div>
</body>
</html>