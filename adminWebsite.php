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
// these are the functions to prompt a confirmation window
function delwebsite(id) {
    if (confirm("Are you sure want to delete this website?") == true) {
		window.location.replace("admin.php?action=deletewebsite&id="+id);
    }
}

function blacklisted(id) {
    if (confirm("Are you sure want to blacklist this website?") == true) {
    
		window.location.replace("admin.php?action=deleteblacklist&id="+id);
    }
}
</script>

<?php
// This is to delete the website
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
// This is tp blacklist the website
if(isset($_GET['action'])){
  if($_GET['action']=='blacklistUrl'){
      if(isset($_GET['id'])){
        $id = $_GET['id'];
        $websiteUrl = $_GET['websiteUrl'];
        $vote = $_GET['vote'];
        mysqli_query($db, "INSERT INTO blacklist (websiteUrl, vote) VALUES ($websiteUrl, $vote)");
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
<?php include 'header.php';?>
</head>
    <body>
    <div class="center">
    <?php include 'adminSidebar.php';?>
        <h2>Welcome back <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h2>
      <table id="website">
              <tr>
                <th class="test">Website Url</th>
                <th class="test">Votes</th>
                <th><a href='addWebsite.php'><button class="website">Add Website</button></a></th>
              </tr>
          <!-- This is the table for the website -->
          <?php
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
        </div>
        <br><br>
    <p>
        <!-- this is to log out -->
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>