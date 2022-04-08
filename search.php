<?php
// Initialize the session
session_start();

// Create connection
$db = mysqli_connect("localhost:3306", "root", "", "test");

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php 
	$output='';
	// This is to get the data from the database
	// and campare it with the user input
	if(isset($_POST['search'])){
		$searchq = $_POST['search'];
		$query = mysqli_query($db, "SELECT * FROM blacklist WHERE websiteUrl LIKE '%$searchq%'") or die("Could not search!");
		$count = mysqli_num_rows($query);
		if($count == 0){
			$output = 'There was no search results!';
		}else{
				while($row = mysqli_fetch_array($query)){
				$sid = $row['id'];
				$sUrl = $row['websiteUrl'];
				$output .= '<div> '.$sid.' '.$sUrl.'<div>';
			}
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'header.php';?>
</head>
<body>
<h2>Hi <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>, welcome back to our site.</h2>
<?php include 'sidebar.php';?>

<div class = "center">
<!-- This is the box for the user search a blacklisted website -->
<form method="post" class="example" action="search.php" style="margin:auto;max-width:300px">
  			<input type="text" placeholder="Search Blacklist" name="search"  style = "height:4%">
            <button class="fa fa-search" type="search" name="Search Blacklist" >Search</button>

</form>
<br><br>
<table id="blacklist">
<tr>
    <th class="test">Blacklisted Sites</th>
    <th class="test">Votes</th>
</tr>
	<?php
	// get data from the database and print it
		$sql = "SELECT * FROM blacklist WHERE websiteUrl LIKE '%$searchq%'";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) > 0) 
		{
			while($row = mysqli_fetch_assoc($result)) 
			{
			echo
            "
                <tr>
                  <td>$row[websiteUrl]</td>
                  <td>$row[vote]</td>
                </tr>     
            ";
			}
		}else{
			echo "<h2 style='text-align:center;'>Sorry! The website has not been blacklisted </h2>";
		}
	?>
    </table>

</div>
<br><br>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>