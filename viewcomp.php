<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: plogin.php");
    exit;
}
$username = $_SESSION["username"];
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['viewall'])){
        $sqlStr = "SELECT * from comp_reg where registerer_id = $username;";
    }

    else if(isset($_POST['viewsolved'])){
        $sqlStr = "SELECT * from comp_reg where registerer_id = $username and  reg_id in (select reg_id from issolved );";
    }

    else if (isset($_POST['viewunsolved'])){
        $sqlStr = "SELECT * from comp_reg where registerer_id = $username and  `reg_id` not in (select reg_id from issolved );";
    }

    else{
        $attribute = $_POST['attribute'];
        $key = $_POST['Search'];
        echo "<script type='text/javascript'>
        alert($attribute);
        </script>";
        if($attribute=="c_phone")
            $sqlStr = "SELECT * FROM comp_reg where c_phone=$key;";

        else if($attribute=="reg_id")
            $sqlStr = "SELECT * FROM comp_reg where reg_id=$key;";

        else
        $sqlStr = "SELECT * FROM comp_reg where $attribute like '%$key%';";
    }

    $result = mysqli_query($link,$sqlStr);
}
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
        <div class="limiter">
            <div class="container-table100">
                <form method="POST" >
                    <div class="wrap-table100">
                        <div class="form-group">
                        <button type="submit" name="viewall" class="btn btn-primary">View All</button>
                        <button type="submit" name="viewunsolved" class="btn btn-primary">View unsolved</button>

                        <button type="submit" name="viewsolved" class="btn btn-primary">View Solved</button></br></br>
                        <label class="text-white">Search by</label></br>

                        <select style="width:200px;height: 35px;border-radius: 5px;" name="attribute" required="">
                        <option value="c_phone">Phone</option>
                        <option value="reg_id">Register number</option>
                        <option value="complainer_name">Complainer name</option>
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

                echo '                <div class="table100">

                <table>
                <thead>
                <tr class="table100-head">
                <th class="column1">Register number</th>
                <th class="column2">Complainer Name</th>
                <th class="column3">Phone number</th>
                <th class="column4">date</th>
                <th class="column5">Description</th>
                <th class="column5">Assigned to</th>
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
                <td class="column5">'.$row['c_descrip'].'</td>
                <td class="column5">'.$row['assnd_to'].'</td>
                </tr>';

                }

                echo '
                </tbody>
                </table>
                </div>';
                }}
                ?>
            </div>
        </div>
    </div>
</body>
</html>