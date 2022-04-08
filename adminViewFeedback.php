<?php
// Create connection
$db = mysqli_connect("localhost:3306", "root", "", "test");
?>


<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Welcome</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<style type="text/css">
			body{ font: 14px sans-serif; text-align: center; }
		</style>
	</head>
	<body>
		<div class="content">
			<div class="MiddleContent">
				<form method="post" action="adminViewFeedback.php">
					<div class="container">
					<h1>View Feedback</h1>
					<?php
						// get the data from the database where the id is equal to the id given
						if (isset($_GET['id'])) {
							$id = trim(mysqli_real_escape_string($db, $_GET['id']));
							$id = intval($id);
							$sql = "SELECT * FROM feedback where id = '".$id."' ";
							$result = mysqli_query($db, $sql);
							if (mysqli_num_rows($result)) 
							{
								while ($row = mysqli_fetch_assoc($result)) {
								// print the data that was taken
								echo
								"<hr>

								<label for='id'>Feedback ID</label><br>
								<input type='text' id='id' name='id' value='$row[id]' readonly><br>

								<label for='title'>Feedback Subject</label><br>
								<input type='text' id='title' name='title' value='$row[title]' readonly><br>
								
								<label for='userfeedback'>User Feedback</label><br>
								<input type='text' id='userfeedback' name='userfeedback' value='$row[userfeedback]' readonly><br>
						
								<hr>";
								}
							}
						}
					?>
					<p>
					<!-- back button -->
					<a href='admin.php'><button type='button'>Back</button></a>
					</p>
				</form>
			</div>
		</div>
	</body>
</html>