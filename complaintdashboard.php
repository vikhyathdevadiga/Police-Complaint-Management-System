<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}

require_once "config.php";

$username = $_SESSION['username'];
//solved cases
$query = "SELECT p_fname, p_lname from police where p_id = $username";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

$fname = $row['p_fname'];
$lname = $row['p_lname'];
$query1 = "SELECT count(DISTINCT i.reg_id) as counts from issolved i , comp_reg c where i.reg_id= c.reg_id and c.assnd_to in (select p_id from police where d_id in (select d_no from department where registerer_id = $username)) ;";
$res1=mysqli_query($link, $query1);
$row1 = mysqli_fetch_assoc($res1);
$solved_cases = $row1['counts'];
//total assignments 

$query2 = "SELECT count(reg_id) as count from comp_reg  where registerer_id = $username ;";
$res2=mysqli_query($link, $query2);

$query3 = "SELECT count(reg_id) as count from comp_reg  where registerer_id = $username and c_date = CURRENT_DATE ;";
$res3=mysqli_query($link, $query3);

$row2 = mysqli_fetch_assoc($res2);
$row3 = mysqli_fetch_assoc($res3);
$tot_assignts = $row2['count'] - $solved_cases;
// echo $username;
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
    include_once 'includes/registersidebar.php' ?>
    <!--sidebar ends-->

<!--Main body-->
<div id="main">
    <h4 style="margin-bottom: 30px;" class="text-center"><?php echo "Hello ".$fname; echo " "; echo $lname; ?></h4>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4 id="text-assign"> Total </br>Cases Registered</h4></br>
                        <h3><?php echo $row2['count']; ?></h3>
                        <div class="easypiechart" id="easypiechart-blue" data-percent="" ><span class="percent"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4 id="text-assign">Today's </br>complaints</h4><br>
                        <strong><h3><?php echo $row3['count']; ?></h3></strong> 
                        <div class="easypiechart" id="easypiechart-orange" data-percent="" ><span class="percent"></span>
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
                        <h3><?php if ($tot_assignts+$solved_cases != 0   ) $percent= $solved_cases/($tot_assignts+$solved_cases)*100; echo $percent."%" ?></h3>
                        <div class="easypiechart" id="easypiechart-teal" data-percent=""><span class="percent"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
