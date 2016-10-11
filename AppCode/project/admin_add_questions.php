<?php
include('Online_Surveys.dbconfig.inc');

// define variables and set to empty values

$question_contentErr = "";
$question_content = ""; # Stores the actual question
$question_name = ""; # Not being used currently

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["question_content"])) {
     $question_contentErr = "Question content is required";
   } else {
	   $question_content=$_POST["question_content"];
   }
}
?>

<html>
<head> ADMIN Add Question Page
<title>
</title>
</head>
<br><br>
<body> 
<a href="admin_homepage.php">Admin Homepage</a>
<a href="admin_create_survey.php">Create Survey</a>
<a href="admin_add_questions.php">Add Questions</a>
<a href="admin_survey_link_questions.php">Link Questions to Surveys</a>
<br><br>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	   
	  Enter Question:
	  <input type="text" name="question_content" value="<?php #echo $question_content;?>">
	  <!-- Check for Errors/ Empty Fields-->
		<?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($question_content == "") { ?>
			<span class="error">* <?php echo $question_contentErr;?></span>
		<?php } }?>
		<br><br>
	  
	  Enter Question Name:
	  <input type="text" name="question_name" value="<?php echo $question_name;?>">
	  <!-- No Check for Empty question name -->
		<br><br>
		
	  <input type="submit" value="Submit">
	  <br><br>
	</form>

<?php
if ($question_content!= "")
{
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$question_id=0;
	$num_rows=0;
	
	$sql = "INSERT INTO tbl_questions VALUES (null, '$question_name', '$question_content',1)";

	// Try inserting this question into the tbl_questions.
	if ($conn->query($sql) === TRUE)
	{
		$question_id = $conn->insert_id;
		echo "New Question Created successfully. question_id: ".$question_id;
	} else 
	{ 	// This question already exists in the tbl_questions,
		echo "<br>" . $conn->error."<br>";
		echo "This Question already exists in the questions' database!";
	}

	$conn->close();
	echo "<br><br>";
}
?>

</body>
</html>



