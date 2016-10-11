<?php
include('Online_Surveys.dbconfig.inc');

?>

<html>
<head>
  <title>Vote+ (Admin Add Questions)</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/login.css"/>
  <link rel="stylesheet" href="css/admin.css"/>
</head>

<body>
	<div id="nav">
	    <ul class="pull-left">
	      <!--
	      <li class="buttonNav"><a href="index.html">HOME</a></li>
	      <li>/</li>-->
	      <li><a href="admin_homepage.php">ADMIN HOME</a></li>
	      <li>/</li>
	      <li><a href="admin_create_survey.php">CREATE SURVEY</a></li>
	      <li>/</li>
	      <li><a href="admin_add_questions.php">ADD QUESTIONS</a></li>
	      <li>/</li>
	      <li><a href="admin_survey_link_questions.php">LINK QUESTIONS</a></li>
	      <li>/</li>
	      <li><a href="admin_view_survey_list.php">VIEW SURVEY LIST</a></li>
	    </ul>
	    <div id="logo"><a href="#"><img src="img/voteLogo.png" height="35" width="62.2"></a></div>
	    <ul class="pull-right">
	      <li><a href="logout.php">LOGOUT</a></li>
	    </ul>
	  </div>
<div id="surveyList">
<?php

$con = mysqli_connect($servername, $username, $password);
if(!$con)
{
	die('Could not connect: ' . mysqli_error());
}
mysqli_select_db($con, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$survey_id=$_POST["survey_id_list"];
	echo "<br>Survey_id: ".$survey_id."<br>";

	//$sql="SELECT question_id FROM tbl_survey_questions WHERE survey_id=$survey_id";
	$sql="SELECT tbl_survey_questions.question_id,
       tbl_questions.question_content,
       tbl_survey_questions.survey_id
  FROM survey_db.tbl_survey_questions tbl_survey_questions
       INNER JOIN survey_db.tbl_questions tbl_questions
          ON (tbl_survey_questions.question_id = tbl_questions.question_id)
 WHERE (tbl_survey_questions.survey_id = $survey_id)";

    $result = mysqli_query($con, $sql);
	$num_rows = mysqli_num_rows($result);
	#echo "DEBUG: num_rows: ".$num_rows. "<br>";

    if($num_rows == 0) // If no question already associated with this survey, exit, since nothing to display
    {
		echo "No questions associated with this survey to display the results!";
		$con->close();
		exit;
	}

	// Initialise the response count variables to 0
	for ($x=1; $x<=$num_rows; $x++)
	{
		for ($y=1; $y<=5; $y++) // Change to options count
		{
			$response_count[$x][$y]=0;
		}
	}

	$questions_count=0;

	while($row=mysqli_fetch_array($result))
    {
		$questions_count++;
		$questions_content_array[$questions_count] = $row['question_content'];
		$questions_id_array[$questions_count] = $row['question_id'];
		$question_id=$questions_id_array[$questions_count];

		// Calculate the response count for each of the responses
		for ($i=1; $i<=5; $i++)  // Here 5 is the number of options
		{
				$response=$i;
				$sql1="SELECT
			   tbl_surveys.survey_name,
			   tbl_survey_questions.question_id,
			   tbl_questions.question_content,
			   COUNT(tbl_user_questions.response)
		  FROM ((survey_db.tbl_survey_questions tbl_survey_questions
				 INNER JOIN survey_db.tbl_surveys tbl_surveys
					ON (tbl_survey_questions.survey_id = tbl_surveys.survey_id))
				INNER JOIN survey_db.tbl_questions tbl_questions
				   ON (tbl_survey_questions.question_id = tbl_questions.question_id))
			   INNER JOIN survey_db.tbl_user_questions tbl_user_questions
				  ON (tbl_user_questions.question_id = tbl_questions.question_id)
		 WHERE     (tbl_survey_questions.survey_id = $survey_id)
			   AND (tbl_survey_questions.question_id = $question_id)
			   AND (tbl_user_questions.response = {$response})
		GROUP BY tbl_questions.question_content";

				$result1 = mysqli_query($con, $sql1);
				$num_rows = mysqli_num_rows($result1);
				if($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC))
				{
						//echo "<br>"; print_r($row1); echo "<br>";
						$response_count[$questions_count][$response]=$row1['COUNT(tbl_user_questions.response)'];
						//echo "Response Count:".$response." is ".$row1['COUNT(tbl_user_questions.response)'];
				}
		}
    }

	// Print List of Questions associated with this survey along with the results
	echo "<table width='386' border='1'> <tr><th>S.No.</th><th>Question Id</th><th>Question</th>
	<th>Response-1</th>
	<th>Response-2</th>
	<th>Response-3</th>
	<th>Response-4</th>
	<th>Response-5</th>
	</tr>";
	echo "<caption> <b> Responses to questions </b> </caption>";
	$i=0;
	while($i<$questions_count)
    {
		$i++;
		echo "<tr><td>".$i."</td><td>".$questions_id_array[$i]."</td><td>".$questions_content_array[$i]."</td>";
		for ($j=1; $j<=5; $j++)
		{
			echo "<td>".$response_count[$i][$j]."</td>";
		}
		echo "</tr>";
    }


}

$con->close();

?>
</div>
</body>
</html>
