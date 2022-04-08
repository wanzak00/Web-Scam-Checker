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
// this is to prompt a confirmation window
function clickVote(id) {
    if (confirm("Are you sure want vote for this website?") == true) {
      window.location.replace("userWebsite.php?action=updateVote&id="+id);
    }
}
</script>

<?php
// update the vote counter
if(isset($_GET['action'])){
  if($_GET['action']=='updateVote'){
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      mysqli_query($db, "UPDATE `website` SET vote = vote + 1 WHERE id='$id'");
      header('location: userWebsite.php');
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<!-- insert header into the website -->
<?php include 'header.php';?>
</head>
<body>
<h2>Hi <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>, welcome back to our site.</h2>
<!-- insert sidebar into the website -->
<?php include 'sidebar.php';?>
<div class = "center">
<!-- This is the table for the websites -->
    <table id="website">
            <tr>
              <th class="test">Website Url</th>
              <th><a href='addWebsite.php'><button class="website">Add Website</button></a></th>
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
                <button onclick='clickVote($row[id])'>Vote</button></a>
                $row[vote]
              </td>
              <td><a href='feedback.php?id={$row['id']}'><button type='edit'>Comment</button></a></td>
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