<?php
include('Online_Surveys.dbconfig.inc');
$userId = $_SESSION["USER_ID"];
?>

<html>
<head>
  <title>Vote+ (User View Survey)</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/login.css"/>
  <link rel="stylesheet" href="css/user.css"/>
</head>
<body>
	<div id="nav">
			<ul class="pull-left">
				<!--
				<li class="buttonNav"><a href="index.html">HOME</a></li>
				<li>/</li>-->
				<li><a href="user_homepage.php">USER HOME</a></li>
				<li>/</li>
				<li><a href="user_view_survey_list.php">VIEW SURVEYS</a></li>
			</ul>
			<div id="logo"><a href="#"><img src="img/voteLogo.png" height="35" width="62.2"></a></div>
			<ul class="pull-right">
				<li><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>
<div id="surveyList">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") // Can span till end of php
{
	$survey_id=$_POST["survey_id_list"];
	$_SESSION["SURVEY_ID"] = $survey_id;
}
echo "<br>surveyId: ".$survey_id."<br>";

$con = mysqli_connect($servername, $username, $password);
if(!$con)
{
	die('Could not connect: ' . mysqli_error());
}
mysqli_select_db($con, $dbname);

// Get List of Survey questions from the database

	$sql="SELECT tbl_questions.question_content, tbl_questions.question_id FROM tbl_questions INNER JOIN tbl_survey_questions ON tbl_questions.question_id = tbl_survey_questions.question_id WHERE tbl_survey_questions.survey_id=$survey_id";
    $result = mysqli_query($con, $sql);
	$num_rows = mysqli_num_rows($result);
	$questions_count=0;

	if ($num_rows == 0) // If there are no questions added to the survey, print, close mysql & exit
	{
		echo "<br>There are no questions added to this survey yet! Please try taking a different survey.<br>";
		$con->close();
		exit;
	}

	echo "<form  method=\"post\" action=\"user_submit_survey.php\">";
	// Print the survey questions in a table.
	echo "<table width='386' border='1'> <tr><th>No.</th><th>Question</th><th>1 (Strongly Disagree) --- 5 (Strongly Agree) </th></tr>";
	echo "<caption> <b> List of survey questions </b> </caption>";
    while($row=mysqli_fetch_array($result))
	{
		//print_r($row); echo "<br>";
		$questions_count++;
		echo "<tr><td>".$questions_count."</td><td>".$row['question_content']."</td><td>";

		//for ($i=1; $i<=$num_options; $i++) // Can add this loop later depending on the number of options.
		{
			echo "<input type=\"radio\" name=\"".$row['question_id']."\" value=\"1\" /> 1 ";
			echo "<input type=\"radio\" name=\"".$row['question_id']."\" value=\"2\" /> 2 ";
			echo "<input type=\"radio\" name=\"".$row['question_id']."\" value=\"3\" CHECKED /> 3 ";
			echo "<input type=\"radio\" name=\"".$row['question_id']."\" value=\"4\" /> 4 ";
			echo "<input type=\"radio\" name=\"".$row['question_id']."\" value=\"5\" /> 5 ";
		}
		echo "</td></tr>";
    }
	echo "<input type=\"hidden\" name=\"survey_id\" value=\"".$survey_id."\" />";
	echo "<input type=\"hidden\" name=\"questions_count\" value=\"".$questions_count."\" />";
	$date_begin=date("Y-m-d H:i:s"); // Get current DATETIME to store in db, format: 2010-02-06 19:30:13
	echo "<input type=\"hidden\" name=\"date_begin\" value=\"".$date_begin."\" />";
	echo "</table>";

	echo "<br><input type=\"submit\" name=\"submit\" value=\"submit\" />";
	echo "</form>";

$con->close();

?>
</div>
</body>
</html>
