<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: plogin.php");
    exit;
}
$username = $_SESSION['username'];
$sqlStr = "SELECT * from issolved i , comp_reg c where i.reg_id= c.reg_id and c.assnd_to = $username ;";
//echo $sqlStr . "<br>";
$result = mysqli_query($link, $sqlStr);
$count = mysqli_num_rows($result);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

if(isset($_POST['details']))
    {
        $cri_id  = $_POST["crid"];
        $_SESSION["cri_id"] = $cri_id;
        session_start(); 
        header("location: criminal_profile.php");
    }
// close connection
mysqli_close($link);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Solved complaints</title>
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
    include_once 'includes/policesidebar.php' ?>
    <!--sidebar ends-->

    <!--Main body-->
    <div id="main">
        <?php
            echo ' 
            <div class="limiter">

            <div class="">
            <div class="wrap-table100">
            <div class="table100">

            <table>
            <thead>
            <tr class="table100-head">
            <th class="column1">Complaint ID</th>
            <th class="column2">Complainer name</th>
            <th class="column3">Phone Number</th>
            <th class="column4">Registered date</th>
            <th class="column5">Rigisterer ID</th>
            <th class="column5">Solved Date</th>
            <th class="column5">Criminal ID</th>
            <th class="column5">See Criminal</th>

                 </tr>
            </thead>';

            echo "<tbody>";
            while ($row = mysqli_fetch_array($result)) {
            echo '
            <tr>
            <td class="column1">'.$row['reg_id'].'</td>
            <td class="column2">'.$row['complainer_name'].'</td>
            <td class="column3">'.$row['c_phone'].'</td>
            <td class="column4">'.$row['c_date'].'</td>
            <td class="column5">'.$row['registerer_id'].'</td>
            <td class="column5">'.$row['sol_date'].'</td>
            <td class="column5">'.$row['cri_id'].'</td>
            <form method = "POST">
            <input type="hidden" name = "crid" value = '.$row['cri_id'].' class="btn btn-primary">
            <td class="column4"><button type="submit" name = "details" class="btn btn-success">See details</button></td>
            </form>
            </tr>';

            }

            echo '
            </tbody>
            </table>
            </div>
            </div>
            </div>
            </div>
            ';
        ?>
    </div>
</body>
</html>