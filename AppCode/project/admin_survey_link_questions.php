<?php
include('Online_Surveys.dbconfig.inc');

?>

<html>
<head> ADMIN link questions to surveys page
<title>
</title>
</head>

<body> 
<a href="admin_homepage.php">Admin Homepage</a>
<a href="admin_create_survey.php">Create Survey</a>
<a href="admin_add_questions.php">Add Questions</a>
<a href="admin_survey_link_questions.php">Add Questions to Surveys</a>
<br><br>

<?php
$con = mysqli_connect($servername, $username, $password);
if(!$con)
{
	die('Could not connect: ' . mysqli_error());
}
mysqli_select_db($con, $dbname);

// Get List of Surveys from the database
echo "<table width='386' border='1'> <tr><th>Survey Id</th><th>Name</th><th>Description</th><th>Start Date</th><th>End Date</th></tr>";
echo "<caption> <b> List of surveys </b> </caption>";
	$sql="SELECT * FROM tbl_surveys";
    $result = mysqli_query($con, $sql);
	$survey_count=0;
	
    while($row=mysqli_fetch_array($result))
    {
		$survey_count++;	
		$survey_names_array[$survey_count] = $row['survey_name'];
		$survey_id_array[$survey_count] = $row[0];
		echo "<tr><td>".$row[0]."</td><td>".$row['survey_name']."</td><td>".$row['survey_description']."</td><td>".$row['survey_open_date']."</td><td>".$row['survey_close_date']."</td></tr>"; 	
    }	
echo "</table>";
echo "<br> Total Surveys: ".$survey_count."<br>";


// Get List of Questions from the database
echo "<table width='386' border='1'> <tr><th>Question Id</th><th>Question</th></tr>";
echo "<caption> <b> List of questions </b> </caption>";
	$sql2="SELECT * FROM tbl_questions";
    $result2 = mysqli_query($con, $sql2);
	$questions_count=0;
	// Numeric array
    while($row2=mysqli_fetch_array($result2))
    {
		$questions_count++;	
		$questions_content_array[$questions_count] = $row2['question_content'];
		$questions_id_array[$questions_count] = $row2[0];
		echo "<tr><td>".$row2[0]."</td><td>".$row2['question_content']."</td></tr>"; 	
    }	
echo "</table>";
echo "<br> Total Questions: ".$questions_count."<br>";

#$con->close();
?>

<br><br>
<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<!-- Display List of Surveys in dropdown box -->
  <select name="survey_id_list">
<?php for ($i=1; $i<=$survey_count; $i++) 
	{?>
    <option value="<?php echo "$survey_id_array[$i]";?>"><?php echo "$survey_names_array[$i]";?></option>
    <?php 
	}?>
  </select>
  
 <!-- Display List of Questions in dropdown box -->
  <select name="question_id_list">
<?php for ($i=1; $i<=$questions_count; $i++) 
	{?>
    <option value="<?php echo "$questions_id_array[$i]";?>"><?php echo "$questions_content_array[$i]";?></option>
    <?php 
	}?>
  </select>
  
  <br><br>
  <input type="submit"  value="Link question to survey">
</form>

<?php 

// Add question_id & survey_id into tbl_survey_questions table.
$question_id = $survey_id = -1;
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$question_id=$_POST["question_id_list"];
	$survey_id=$_POST["survey_id_list"];
	#echo "DEBUG: question_id: ".$question_id. "survey_id: ".$survey_id."<br>";

	$sql2="SELECT * FROM tbl_survey_questions WHERE survey_id=$survey_id AND question_id=$question_id";
    $result2 = mysqli_query($con, $sql2);
	$num_rows = mysqli_num_rows($result2);
	#echo "DEBUG: num_rows: ".$num_rows. "<br>";
	
    if($num_rows == 0) // If this question is not already associated with a survey, associate it.
    {	
		$sql = "INSERT INTO tbl_survey_questions VALUES (null, '$survey_id', '$question_id')";

		// Try inserting the question_id, survey_id combination into the tbl_survey_questions.
		if ($con->query($sql) == TRUE)
		{
			$survey_question_id = $con->insert_id;
			echo "question_id: ".$question_id. " added successfully to Survey_id: ".$survey_id. "!";
		} else 
		{
			echo "Debug: Error: " . $sql . "<br>" . $con->error;
		}
    } else 
	{
		echo "question_id: ".$question_id. " is already associated to Survey_id: ".$survey_id. " !!";
	}
}

$con->close();

?>

</body>
</html>



