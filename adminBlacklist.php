<?php  
// Initialize the session
session_start();

// Create connection
$db = mysqli_connect("localhost:3306", "root", "", "test");

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} ?>

<script>
// these is the function to prompt a confirmation window
function delblacklist(id) {
    if (confirm("Are you sure want to delete this blacklisted website?") == true) {
		window.location.replace("admin.php?action=deleteblacklist&id="+id);
    }
}
</script>

<?php
// This is to delete the blacklist
if(isset($_GET['action'])){
  if($_GET['action']=='deleteblacklist'){
      if(isset($_GET['id'])){
        $id = $_GET['id'];
        mysqli_query($db, "DELETE FROM `blacklist` WHERE id='$id'");
        header('location: admin.php');
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<!-- insert header into the website -->
<?php include 'header.php';?>
</head>
  <body>
    <div class="center">
    <!-- insert sidebar into the website -->
    <?php include 'adminSidebar.php';?>
      <!-- This is the title -->
      <h2>Welcome back <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h2>
      <!-- This is the table for the blacklist -->
        <table id="blacklist">
            <tr>
                <th class="test">Blacklisted Websites</th>
                <th class="test">Votes</th>
            </tr>
            <?php
            // this is to get the data from the database and print it line by line
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
                <td>
                    <button onclick='delblacklist($row[id])'>Delete</button>
                </td>
                </tr>";
                }   
            } 
            ?>
        </table>
        </div>
        <br><br>
    <p>
        <!-- this is to log out -->
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>