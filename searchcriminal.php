<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: plogin.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
$attribute = $_POST['attribute'];
$key = $_POST['Search'];
echo "<script type='text/javascript'>
                alert($attribute);
            </script>";
            if($attribute=="cri_id")
$sqlStr = "SELECT * FROM crimial where cri_id=$key;";
else if($attribute=='sex'){
     $sqlStr = "SELECT * FROM crimial where $attribute = '$key';";
}
else{
    $sqlStr = "SELECT * FROM crimial where $attribute like '%$key%';";
}
$result = mysqli_query($link,$sqlStr);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Criminal</title>
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
        <div class="limiter">
            <div class="container-table100">
                <form method="POST" >
                    <div class="wrap-table100">
                        <div class="form-group">
                            <label class="text-white">Search by</label></br>
                            <select style="width:200px;height: 35px;border-radius: 5px;" name="attribute" required="">
                            <option value="cri_id">Criminal ID</option>
                            <option value="cri_name">Criminal Name</option>
                            <option value="sex">Sex</option>
                            <option value="lastseenaddr">Location</option>
                            </select>
                        </div>
                        <input style = "border-radius:30px; margin-bottom:20px;width:350px;height:40px;" type = "text" placeholder = "Search" name="Search">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form> 

                <?php 
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!($result) || mysqli_num_rows($result)==0)
            {
                echo '<h4 class = "text-white">No records found!</h4>';
            }
            else{

        echo '      <div class="wrap-table100">          
                    <div class="table100">
                         
                            <table>
                                <thead>
                                    <tr class="table100-head">
                                        <th class="column1">criminal ID</th>
                                        <th class="column2">Criminal Name</th>
                                        <th class="column3">sex</th>
                                        <th class="column4">date of birth</th>
                                        <th class="column5">last seen</th>
                                                             </tr>
                                </thead>';

                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
            echo '
                <tr>
                    <td class="column1">'.$row['cri_id'].'</td>
                    <td class="column2">'.$row['cri_name'].'</td>
                    <td class="column3">'.$row['sex'].'</td>
                    <td class="column4">'.$row['dob'].'</td>
                    <td class="column5">'.$row['lastseenaddr'].'</td>
                </tr>';

        }

        echo '
         </tbody>
                            </table>
                        </div>
                        </div>';
        }}
         ?>

            </div>
        </div>                    
    </div>
</body>
</html>