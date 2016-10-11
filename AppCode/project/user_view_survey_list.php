<?php
include('Online_Surveys.dbconfig.inc');
$userId = $_SESSION['USER_ID'];
?>


<html>
<head> USER Page - View List of Surveys
<title>

</title>
</head>
<body> 
<a href="user_homepage.php">Homepage</a>

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
	$sql="SELECT * FROM tbl_surveys ORDER BY survey_id";
    $result = mysqli_query($con, $sql);
	$survey_count=0;
	// Numeric array
    while($row=mysqli_fetch_array($result))
    {
		$survey_count++;	
		$survey_names_array[$survey_count] = $row['survey_name'];
		$survey_id_array[$survey_count] = $row[0];
		echo "<tr><td>".$row[0]."</td><td>".$row['survey_name']."</td><td>".$row['survey_description']."</td><td>".$row['survey_open_date']."</td><td>".$row['survey_close_date']."</td></tr>"; 	
    }	
echo "</table>";
echo "<br> Total Surveys: ".$survey_count."<br>";

// Get List of completed surveys by this user from the tbl_user_surveys
	$sql2="SELECT * FROM tbl_user_surveys WHERE user_id=$userId ORDER BY survey_id";
	#echo "DEBUG: ".$sql2."<br>";
    $result2 = mysqli_query($con, $sql2);
	$survey_completed_count=0; // Number of Surveys completed by this user.
	
    while($row2=mysqli_fetch_array($result2))
    {
		$survey_completed_count++;	
		$survey_completed_array[$survey_completed_count] = $row2['survey_id'];
    }	
echo "<br> Number of Surveys already completed: ".$survey_completed_count;
if ($survey_completed_count!=0)
{
// print list of survey completed by the user.
	echo " Completed surveyId List: ";
	for ($k=1; $k <= $survey_completed_count; $k++)
	{
		echo "$survey_completed_array[$k]";
		if ($k!=$survey_completed_count) echo ", ";
		else echo ".";
	}
}

// Get List of surveys not completed by this user	
	$survey_id_array_copy = $survey_id_array;
	$i= $j=1; 
	while ($i <= $survey_count && $j <= $survey_completed_count)
	{
		if ($survey_id_array_copy[$i] < $survey_completed_array[$j])
		{
			$i++;
		} elseif ($survey_id_array_copy[$i] > $survey_completed_array[$j])
		{
			$j++;
		} else // SurveyId's match, meaning user has completed these surveys, mark it.
		{
			$survey_id_array_copy[$i] = -1;
			$i++; $j++;
		}		
	}
	$survey_not_completed_count=0;
	for ($i=1; $i<=$survey_count; $i++)
	{
		if ($survey_id_array_copy[$i] != -1)
		{
			$survey_not_completed_count++;
			$survey_not_completed_array[$survey_not_completed_count] = $survey_id_array_copy[$i];
		}
	}
	
echo "<br> Number of Surveys yet to be completed: ".$survey_not_completed_count."<br>";
if ($survey_not_completed_count!=0)
{
// print list of survey not completed by the user.
	echo " List of surveys to be completed: ";
	for ($k=1; $k <= $survey_not_completed_count; $k++)
	{
		echo "$survey_not_completed_array[$k]";
		if ($k!=$survey_not_completed_count) echo ", ";
		else echo ".";
	}
}

$con->close();
?>

<br><br>
Select a survey & click "Start Survey" to begin answering the survey. 
<form  method="post" action="user_take_survey.php">
<!-- Display List of Surveys in dropdown box -->
  <select name="survey_id_list">
<?php for ($i=1; $i<=$survey_not_completed_count; $i++) 
	{?>
    <option value="<?php echo "$survey_not_completed_array[$i]";?>"><?php echo "$survey_not_completed_array[$i]";?></option>
    <?php 
	}?>
  </select>
 
  <input type="submit"  value="Start Survey">
</form>

</body>
</html>



