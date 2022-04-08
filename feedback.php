<?php
// Create connection
$db = mysqli_connect("localhost:3306", "root", "", "test");
?>

<!doctype html>
<html>
<head>
<?php include 'header.php';?>
</head>
	<body>
        <div class="content">
            <br>  
            <div class="MiddleContent">
                <form method="post" action="feedback.php">
                    <div class="container">
                    <h1>User Feedback</h1>
                    <?php
						if (isset($_GET['id'])) {
							$id = trim(mysqli_real_escape_string($db, $_GET['id']));
							$id = intval($id);
							$sql = "SELECT * FROM website where id = '".$id."' ";
							$result = mysqli_query($db, $sql);
							if (mysqli_num_rows($result)) 
							{
								while ($row = mysqli_fetch_assoc($result)) {
								echo
								"<hr>

								<label for='title'>Feedback Subject</label><br>
								<input type='text' id='title' name='title' value='$row[websiteUrl]' readonly><br>
								
								<label for='userfeedback'>User Feedback</label><br>
								<input type='text' id='userfeedback' name='userfeedback' value='' edit><br>
						
								<hr>";
								}
							}
						}
					?>       
                </form>
                <button class="btn" type="submit" name="save" >Submit</button>
                <?php 
                // initialize variables
                $title = "";
                $userfeedback = "";

                if (isset($_POST['save'])) {
                    $title = $_POST['title'];
                    $userfeedback = $_POST['userfeedback'];
                    mysqli_query($db, "INSERT INTO feedback (title, userfeedback) VALUES ('$title','$userfeedback')");
                    header('location: userWebsite.php');
                }
                ?>
            </div>
        </div>
    </body>
</html>