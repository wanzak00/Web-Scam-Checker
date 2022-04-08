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
function delfeedback(id) {
    if (confirm("Are you sure want to delete this feedback?") == true) {
		window.location.replace("admin.php?action=deletefeedback&id="+id);
    }
}
</script>

<?php
// This is to delete the feedback
if(isset($_GET['action'])){
  if($_GET['action']=='deletefeedback'){
      if(isset($_GET['id'])){
        $id = $_GET['id'];
        mysqli_query($db, "DELETE FROM `feedback` WHERE id='$id'");
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
      <!-- This is the table for the feedback -->
        <table id="feedback">
        <tr>
            <th class="test">User Feedbacks</th>
        </tr>
          <?php
            // this is to get the data from the database and print it line by line
            $sql ="SELECT * FROM feedback";
            $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0) 
            {
                while($row = mysqli_fetch_assoc($result)) 
                {
                echo
                "<tr>
                    <td>$row[title]</td>
                    <td>
                    <a href='adminViewFeedback.php?id={$row['id']}'>
                    <button type='edit'>View</button></a>
                    </td>
                    <td><button onclick='delFeedback($row[id])'>Delete</button></td>
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