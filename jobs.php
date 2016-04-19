<?php
	include_once('config.php');
	include_once('dbutils.php');
?>
<?php
// check if user logged in, if not, kick them to login.php
session_start();
if(!isset($_SESSION['username'])) {
	// if this is not set, it means they are not logged in
	header("Location: login.php");
}

$menuActive="1"	
?>


<html>
<!--
Reached by click JOBS on navbar. View and ADD jobs
Orginally created by Trenton, if you have an questions ask.
-->
<header>

<title> Jobs </title>

<!-- BOOTSTRAP CODE -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!-- NAVBAR STYLE REF CSS -->
<link rel="stylesheet" href="navbarstyle.css">

<!--ADDITIONAL CSS-->
<style>
.container {
	padding: 60px 20px;
	letter-spacing: 2px;
}
.container-2 {
	padding: 20px 20px;	
	letter-spacing: 2px;
	color: white;
}

</style>
</header>

<body>


<div class="container">
<!--NAV BAR -->
<?php
	include_once('navbar.php')
?>

<!--This is a center block, helps keep vertyhing in the center for the theme-->

<div class="center-block col-sm-12" style="float: none; background-color: #52BE80">
<div class="container-2">


<?php
// Back to PHP to perform the search if one has been submitted. Note
// that $_POST['submit'] will be set only if you invoke this PHP code as
// the result of a POST action, presumably from having pressed Submit
// on the form we just displayed above.
if (isset($_POST['submit'])) {
//	echo '<p>we are processing form data</p>';
//	print_r($_POST);

	// get data from the input fields
	$Business_Name = $_POST['Business_Name'];
	$Business_Address = $_POST['Business_Address'];
	$Position = $_POST['Position'];
	

	if (!$Business_Name) {
		punt("Please enter a Business Name");
	}
	if (!$Business_Address) {
		punt("Please enter a Business Address");
	}
	
	


	// connect
	$db = connectDB($DBHost,$DBUser,$DBPasswd,$DBName);
	

	// Business TABLE FIRST
	$query = "INSERT INTO Business_T(Business_Name, Business_Address) VALUES ('$Business_Name', '$Business_Address');";
	$result = queryDB($query, $db);
	
	// Job Table NEXT
	// HAD AN ERROR TALK TO TEAM
	

	
}
?>



<!-- PAGE HEADER -->
	<div class="col-xs-12">
		<h1><center><font color="White"><strong> Jobs </strong></font></center><hr width="50%"></h1>
	</div>
	


<!--List of Current Jobs-->
	<h4><font color="white"><b>Current Jobs</b></font></h4>
	<!--TABLE THAT SHOWS JOBS OF USER-->

<?php
	
	
//CREATING QUERY TO VIEW Business DROP BOX
$db = connectDB($DBHost,$DBUser,$DBPasswd,$DBName);
$query = "SELECT BID, Business_Name, Business_Address FROM Business_T ORDER BY Business_Name;";
$result = queryDB($query, $db);

$Business_Options = "";

if (nTuples($result) > 0) {
    while ($row=nextTuple($result)) {
		$Business_Options .= "\t\t\t";
		$Business_Options .= "<option value='";
		$Business_Options .= $row['BID'] . "'>" . $row['Business_Name'] .  $row['Business_Address'] . "</option>\n";
		}
	}
?>

	
	
	<!--ADD JOBS-->
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<h4><font color="white"><b>Add Job </b></font></h4>

		<!-- Shows Business name and address GROUP -->
		<div class="form-group"><div class="col-sm-12">
		<div class="input-group">
			<!-- Drop down box -->
			<select class="form-control"><?php echo $Business_Options; ?></select>
				
				<!-- button to add a new job -->
				<div class="input-group-btn">
					<a class="btn btn-default" href="addjob.php" type="button">Don't see your Business?</a>
				</div>
		</div>
		</div>
		</div>
		
		<!--Business Address name= Position-->
		<div class="form-group">
			<div class="col-sm-12"> <input type="text" class="form-control" name="Position" placeholder="Your Position"> </div>
		</div>
		
		<!--BUTTON-->
		<center><button type="submit" class="btn btn-default btn-lg" name="submit">Submit</button></center>
	</form>

</div>


</body>


<footer>
<?php
	include_once('footer.php');
?>
</footer>
</div>
</div>
