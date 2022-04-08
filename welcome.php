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

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'header.php';?>
</head>
<body>
<h2>Hi <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>, welcome back to our site.</h2>
<?php include 'sidebar.php';?>

<div class = "center">
<!-- this is the search box -->
<form method="post" class="example" action="search.php" style="margin:auto;max-width:300px">
  			<input type="text" placeholder="Search Blacklist" name="search"  style = "height:4%">
            <button class="fa fa-search" type="search" name="Search Blacklist" >Search</button>

	</form>

</div>
<br><br>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>