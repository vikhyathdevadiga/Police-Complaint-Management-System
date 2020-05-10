<?php
    // Initialize the session
    session_start();
    require_once 'config.php';
    $cri_id = $_SESSION["cri_id"];

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: plogin.php");
        exit;
    }
?>

<DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatiable" content="ie=edge">

    <title>Criminal profile</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.css">

    <!-- Fontawesom -->
    <link rel="stylesheet" type="text/css" href="fonts\font-awesome\css\font-awesome.css">

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="css/styleadmin.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

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
            <!-- Main body contents goes here -->

            <h1 style="text-align: center;"> Criminal Profile</h1>

            <?php
            if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
            if (!defined('DB_USERNAME')) define('DB_USERNAME', 'localhost');
            if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
            if (!defined('DB_NAME')) define('DB_NAME', 'lawyeronline');
            $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Attempt select query execution
            $sql = "SELECT * FROM `crimial` where `cri_id` = $cri_id";
            if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result))
                    {
                    echo '<!--Services details start-->
                    <div class="doctor_details_pages pt--100">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div style = "margin-left:50px; margin-top:40px;" class="doctor_profile_img">
                                        <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'"width="350" height="350" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div>
                                        <div>
                                            <div>
                                                <h2 style = " margin-top:40px;" >';echo ' Criminal Name :  '.$row['cri_name'].'';echo '</h2>

                                                <p style = " margin-top:20px;" >';echo ' Gender :  '.$row['sex'].'';echo '</p>
                                                <p style = " margin-top:20px;" >';echo ' Criminal ID :  '.$row['cri_id'].'';echo '</p>
                                                <p style = " margin-top:20px;" >';echo ' Last seen location:  '.$row['lastseenaddr'].'';echo '</p>
                                                <p style = " margin-top:20px;" >';echo ' Description about criminal   :  '.$row['descrip'].'';echo '</p>
                                            </div>
                                            <a name = "details" class="btn btn-success text-white" href= "solveddisp.php">Go back</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                    // Free result set
                    mysqli_free_result($result);
                }else{
                    echo "No records matching your query were found.";
                }
            }else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
            // Close connection
            mysqli_close($link);
            ?>
        </div>
        <!--Main body ends-->

        <script type="text/javascript" src="bootstrap\js\jQuery.js"></script>
        <script type="text/javascript" src="bootstrap\js\bootstrap.bundle.js"></script>
        <script type="text/javascript" src="bootstrap\js\bootstrap.js"></script>
        <script type="text/javascript" src="js/sidebar.js"></script>
    </body>
</html>