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

<script>
// these are the functions to prompt a confirmation window
function delwebsite(id) {
    if (confirm("Are you sure want to delete this website?") == true) {
		window.location.replace("admin.php?action=deletewebsite&id="+id);
    }
}
function delfeedback(id) {
    if (confirm("Are you sure want to delete this feedback?") == true) {
		window.location.replace("admin.php?action=deletefeedback&id="+id);
    }
}
function delblacklist(id) {
    if (confirm("Are you sure want to delete this blacklisted website?") == true) {
		window.location.replace("admin.php?action=deleteblacklist&id="+id);
    }
}
function blacklisted(id) {
    if (confirm("Are you sure want to blacklist this website?") == true) {
		window.location.replace("admin.php?action=blacklistUrl&id="+id);
    }
}
</script>

<?php
// Tis is to delete the website
if(isset($_GET['action'])){
  if($_GET['action']=='deletewebsite'){
      if(isset($_GET['id'])){
        $id = $_GET['id'];
        mysqli_query($db, "DELETE FROM `website` WHERE id='$id'");
        header('location: admin.php');
      }
    }
}
?>

<?php
// Tis is to delete the feedback
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

<?php
// Tis is to delete the blacklist website
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

<?php
// Tis is to blacklist the website and delete it from the website table
if(isset($_GET['action'])){
  if($_GET['action']=='blacklistUrl'){
      if(isset($_GET['id'])){
        $id = $_GET['id'];
        mysqli_query($db, "INSERT INTO `blacklist` (websiteUrl, vote)  SELECT websiteUrl, vote FROM website WHERE id='$id'");
        mysqli_query($db, "DELETE FROM `website` WHERE id='$id'");
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
      <!-- This is the table for the websites -->
      <table id="website">
              <tr>
                <th class="test">Website Url</th>
                <th class="test">Votes</th>
                <th><a href='addWebsiteAdmin.php'><button class="website">Add Website</button></a></th>
              </tr>
          <?php
          // this is to get the data from the database and print it line by line
          $sql ="SELECT * FROM website";
          $result = mysqli_query($db, $sql);
          if (mysqli_num_rows($result) > 0) 
          {
              while($row = mysqli_fetch_assoc($result)) 
              {
              echo
              "<tr>
                <td>$row[websiteUrl]</td>
                <td>
                  $row[vote]
                </td>
                <td>
                  <button onclick='delwebsite($row[id])'>Delete</button>
                </td>
                <td>
                  <button onclick='blacklisted($row[id])'>Blacklist</button>
              </td>
              </tr>";
              }   
          } 
          ?>
        </table>

        <br>
        <!-- this is the table for the blacklisted website -->
        <table id="blacklist">
        <tr>
            <th class="test">Blacklisted Sites</th>
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

        <br>
        <!-- this is the table for the feedbacks -->
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
                <td><button onclick='delfeedback($row[id])'>Delete</button></td>
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