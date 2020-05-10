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
//solved cases
$query1 = "SELECT count(DISTINCT i.reg_id) as counts from issolved i , comp_reg c where i.reg_id= c.reg_id and c.assnd_to = $username;";
$res1=mysqli_query($link, $query1);
$row1 = mysqli_fetch_assoc($res1);
$solved_cases = $row1['counts'];
//total assignments 
$query2 = "SELECT count((reg_id)) as count from comp_reg  where assnd_to = $username ;";
$res2=mysqli_query($link, $query2);

$row2 = mysqli_fetch_assoc($res2);
$tot_assignts = $row2['count'] - $solved_cases;
?>
 <DOCTYPE html>
<html>
<head>

	<title>Admin-Page</title>
  
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
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <h4 id="text-assign"> Today's </br>Assignments</h4></br>
                            <h3><?php echo $tot_assignts; ?></h3>
                            <div class="easypiechart" id="easypiechart-blue" data-percent="" >
                                <span class="percent"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <h4 id="text-assign">Total cases </br>solved</h4><br>
                            <strong><h3><?php echo "$solved_cases"; ?></h3></strong> 
                            <div class="easypiechart" id="easypiechart-orange" data-percent="" >
                                <span class="percent"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <h4 id="text-assign">Success ratio</h4><br><br> 
                            <h3><?php $percent= 0; if ($tot_assignts+$solved_cases != 0   ) $percent= $solved_cases/($tot_assignts+$solved_cases)*100; echo $percent."%" ; ?></h3>
                            <div class="easypiechart" id="easypiechart-teal" data-percent="">
                                <span class="percent"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            $query = "SELECT * fROM station where s_head = $username;";
            $res1=mysqli_query($link, $query);
            if(mysqli_num_rows($res1) == 0){
            echo "";
            }
            else{
            echo '<a href="reg_police.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Add New Police</a>';
            }
            mysqli_close($link);
            ?>
        </div>  
    </div>
    <!--Main body ends-->
</body>
</html>
