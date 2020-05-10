<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}
$username = $_SESSION['username'];
//solved cases
$query1 = "SELECT count(*) as counts from issolved i , comp_reg c where i.reg_id= c.reg_id and c.assnd_to = $username ;";
$res1=mysqli_query($link, $query1);
$row1 = mysqli_fetch_assoc($res1);
$solved_cases = $row1['counts'];
//total assignments 
$query2 = "SELECT count(reg_id) as count from comp_reg  where assnd_to = $username ;";
$res2=mysqli_query($link, $query2);

$row2 = mysqli_fetch_assoc($res2);
$tot_assignts = $row2['count'] - $solved_cases;
// echo $username;
// echo $tot_assignts;

mysqli_close($link);
?>
 <DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatiable" content="ie=edge">

	<title>Admin-Page</title>

	<?php 
    include_once 'includes/header.php' ?>
    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="css/styleadmin.css"> 
</head>
<body>

    <!-- navbar starts -->
    <?php 
    include_once 'includes/policenavbar.php' ?> 
    <!-- navbar ends-->
    
    <!--sidebar starts-->
    <?php 
    include_once 'includes/policesidebar.php' ?>
    <!--sidebar ends-->

    <!--Main body-->
    <div id="main">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <h4 id="text-assign"> Today's </br>Assignments</h4></br>
                            <h3><?php echo $tot_assignts; ?></h3>
                            <div class="easypiechart" id="easypiechart-blue" data-percent="" ><span class="percent"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <h4 id="text-assign">Total cases </br>solved</h4><br>
                            <strong><h3><?php echo "$solved_cases"; ?></h3></strong> 
                            <div class="easypiechart" id="easypiechart-orange" data-percent="" ><span class="percent"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <h4 id="text-assign">Success ratio</h4><br><br> 
                            <h3><?php if ($tot_assignts+$solved_cases != 0   ) echo $solved_cases/($tot_assignts+$solved_cases); ?></h3>
                            <div class="easypiechart" id="easypiechart-teal" data-percent=""><span class="percent"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>  
    </div>
    <!--Main body ends-->
<script type="text/javascript" src="bootstrap\js\jQuery.js"></script>
<script type="text/javascript" src="bootstrap\js\bootstrap.bundle.js"></script>
<script type="text/javascript" src="bootstrap\js\bootstrap.js"></script>
<script type="text/javascript" src="js/sidebar.js"></script>
</body>
</html>
