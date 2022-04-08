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

<!doctype html>
<html>
<head>
<?php include 'header.php';?>
</head>
	<body>
        <div class="content">
            <div class="MiddleContent">
                <h2>Your website url has been added.</h2>
            </div>
        </div>
        <p>
        <a href='welcome.php'><button type='button'>Home</button></a>
        </p>
	</body>
</html>