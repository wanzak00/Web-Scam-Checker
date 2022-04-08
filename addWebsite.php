<?php  
// Create connection
$db = mysqli_connect("localhost:3306", "root", "", "test");
?>

<?php
// initialize variables
$websiteUrlErr = "";
$websiteUrl = "";
// check the input to see if it is a website url
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["websiteUrl"])) {
        $websiteUrlErr = "Website Url is required";
    } 
    else {
        $websiteUrl = test_input($_POST["websiteUrl"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$websiteUrl)) {
            $websiteUrlErr = "Invalid URL";
        }
        else{
            // insert the data into the database
            $websiteUrl = $_POST['websiteUrl'];
            mysqli_query($db, "INSERT INTO website (`websiteUrl`) VALUES ('$websiteUrl')");
            header('location: confirmationWebsite.php');
        }
    }
}

// this is the function to change characters to string
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



<!doctype html>
<html>
<head>
<!-- insert header into the website -->
<?php include 'header.php';?>
</head>
	<body>
    <!-- insert sidebar into the website -->
    <?php include 'sidebar.php';?>
        <div class="content">
            <div class="MiddleContent">
            <!-- insert the data into the database -->
            <form method="post" action="addWebsite.php">
                <div class="container">
                <h2>Add A Website Url</h2>
                <br><br>
                Website: <input type="text" name="websiteUrl" value="<?php echo $websiteUrl;?>">
                <span class="error"><?php echo $websiteUrlErr;?></span>
            </form>
            <!-- button to submit -->
            <button class="btn" type="submit" name="submit_url" >Submit</button>
            <?php 
            ?>
            </div>
        </div>
	</body>
</html>
