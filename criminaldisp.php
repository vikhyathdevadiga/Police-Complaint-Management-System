<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: plogin.php");
    exit;
}

$sqlStr = "SELECT * FROM crimial;";
//echo $sqlStr . "<br>";
$result = mysqli_query($link, $sqlStr);
$count = mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html>
<head>
	<title>criminal details</title>
	<?php 
    include_once 'includes/header.php' ?>

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="css/styleadmin.css">

    
</head>
<body>
    
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
    echo '<div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                     
                        <table>
                            <thead>
                                <tr class="table100-head">
                                    <th class="column1">criminal ID</th>
                                    <th class="column2">Criminal Name</th>
                                    <th class="column3">sex</th>
                                    <th class="column4">date of birth</th>
                                    <th class="column5">last seen</th>
                                    <th class="column5">Photo</th>
                                </tr>
                            </thead>';
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo'<tr>
                                    <td class="column1">'.$row['cri_id'].'</td>
                                    <td class="column2">'.$row['cri_name'].'</td>
                                    <td class="column3">'.$row['sex'].'</td>
                                    <td class="column4">'.$row['dob'].'</td>
                                    <td class="column5">'.$row['lastseenaddr'].'</td>
                                    <td class="column5"><div class="doctor_image_2">
                                    <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'"width="120" height="120" alt="">
                                    </div>
                                    </td>
                                </tr>';
                            }
                        echo '</tbody>
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