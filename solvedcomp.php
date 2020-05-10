<?php
// Initialize the session
	$cri_name = "";
	$cri_sex = "";
	$cri_dob = "";
	$lseen = "";
	$criid = 0;
	$desc = "";

$regid = 0;
session_start();
require_once "config.php";
$regid =  $_SESSION["lid"];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: plogin.php");
    exit;
}

$sqlStr = "SELECT * FROM crimial;";
//echo $sqlStr . "<br>";
$result = mysqli_query($link, $sqlStr);
$count = mysqli_num_rows($result);

$maximum =  "SELECT MAX(cri_id) as maximum from crimial";
$result1 = mysqli_query($link,$maximum);
$row1 = mysqli_fetch_assoc($result1);
$max = $row1['maximum'];
$max = $max + 1;
// echo $regid;

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if (isset($_POST['select'])) {
		# code...

	$criid = $_POST['crid'];	
	$criminal = "SELECT * FROM crimial WHERE `cri_id` = $criid";
	$res = mysqli_query($link, $criminal);
	$rows = mysqli_fetch_array($res);
	$cri_name = $rows['cri_name'];
	$cri_sex = $rows['sex'];
	$cri_dob =  $rows['dob'];
	$lseen = $rows['lastseenaddr'];
	$desc = $rows['descrip'];
	// $insert = "INSERT INTO `issolved`(`reg_id`, `sol_date`, `cri_id`) VALUES ($regid,[value-2],[value-3]);";
}
else
{
	$lastseen = $_POST['lsaddr'];
	if ($criid == 0) {

	# code...
	// $criid = $_POST[]
	$target = "uploads/".basename($_FILES['myimage']['name']);
	$filename = addslashes($_FILES['myimage']['name']);


	if(!empty($filename))
{
  $tmpname = addslashes(file_get_contents($_FILES['myimage']['tmp_name']));
  $filetype = addslashes($_FILES['myimage']['type']);
  $array = array('jpg','jpeg');
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  if (!in_array($ext, $array)) {
  # code...
  	echo "Unsupported file type!";
 }

}

else
{
  $tmpname = "null";
  $filename = "null";
}




	$criid = $max;
	$date = $_POST['date'];
	$cname = $_POST['criname'];
	$sex =  $_POST['gender'];
	$dob = $_POST['dob'];
	$last = $_POST['lsaddr'];
	$cri_insert = "INSERT INTO `crimial`(`cri_id`, `cri_name`, `sex`, `dob`, `descrip`, `lastseenaddr`, `cri_img_name`, `image`) VALUES ($criid,'$cname','$sex', '$dob', '$desc', $last','$filename','$tmpname');";
	// $rest=mysqli_query($link, $cri_insert);
	mysqli_query($link, $cri_insert);
	}
	
else{
	$date = $_POST['date'];
	if($lseen != $lastseen)
	{
		$queryupdate== "UPDATE `crimial` SET `lastseenaddr` = $lastseen;";
		$resupdate = mysqli_query($link, $queryupdate);
	}

}

$insert = "INSERT INTO `issolved`(`reg_id`, `sol_date`, `cri_id`) VALUES ($regid,'$date',$max);";	
if(mysqli_query($link, $insert)){
    echo "<script type='text/javascript'>
                alert('Records added successfully!!');
            </script>";
	}
	else
	{
		echo "<script type='text/javascript'>
                alert('Something went wrong!');
            </script>";
	}
}
}
?>

<!DOCTYPE html>
<html>
<head>
	
	<title>Solved Complaints</title>
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
		<h3 style="padding-top: 40px;" id="boys">Enter details of the Criminal</h3>
		<h5 style="padding-bottom: 40px;" id="boys"> (Or select from the table below)</h5>

		<?php
		echo ' 
		<div class="limiter">

		<div class="wrap-table100">
		<div class="">

		<table>
		<thead>
		<tr class="table100-head">
		<th class="column1">criminal ID</th>
		<th class="column2">Criminal Name</th>
		<th class="column3">sex</th>
		<th class="column4">date of birth</th>
		<th class="column5">last seen</th>
		<th class="column4">Select</th>
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
		<form method = "POST" action = "solvedcomp.php">
		<input type="hidden" name = "crid" value = '.$row['cri_id'].' class="btn btn-primary">
		<td class="column4"><button type="submit" name = "select" class="btn btn-success">Select</button></td>
		</form>
		</tr>';

		}

		echo '
		</tbody>
		</table>
		</div>
		</div>
		</div>
		';
		?>

		<form method="POST" enctype="multipart/form-data">
			<div class="container">
				<div class="form-group">
				<!--Complaint Registry-->
				Solved date:<br>
				<input type="text"  class="form-control"  name="date" placeholder="Enter Solved date" ><br>

				Criminal name:<br>
				<input type="text" class="form-control" name="criname" value="<?php echo $cri_name ?>" placeholder="Enter Criminal name" ><br>

				Gender:<br>
				<div class="form-group">
				<label class="text-white">Gender</label></br>
				<select style="width:200px;height: 35px;border-radius: 5px;" value="<?php echo $cri_sex ?>" name="gender" required="">
				<option value="male">Male</option>
				<option value="female">Female</option>
				<option value="other">Other</option>
				</select>
				</div>

				Date of birth:<br>
				<input type="text" class="form-control" value="<?php echo $cri_dob ?>"  name="dob" placeholder="mm-dd-yyyy"><br>

				<div class="form-group">
				<label>Upload image</label>
				<input type="file" name="myimage" class="form-control" ><br/>
				</div>

				Last seen Address:<br>
				<input type="text" class="form-control" name="lsaddr" value="<?php echo $lseen ?>" placeholder="Enter last seen location" ><br>
				Description about Criminlal:<br>
				<textarea cols="50" class="form-control" name="description" rows="5"></textarea>	

				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
	<!--Main body ends-->
</html>