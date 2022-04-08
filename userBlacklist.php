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
    <table id="blacklist">
        <tr>
            <th class="test">Blacklisted Websites</th>
        </tr>
        <?php
        $sql ="SELECT * FROM blacklist";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result)) 
            {
            echo
            "<tr>
              <td>$row[websiteUrl]</td>
              <td>$row[vote]</td>
            </tr>";
            }   
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