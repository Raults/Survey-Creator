<?php
include('Online_Surveys.dbconfig.inc');
?>

<html>
<head> ADMIN View Survey List page
<title>
</title>
</head>

<body> 
<a href="admin_homepage.php">Admin Homepage</a>
<a href="admin_create_survey.php">Create Survey</a>
<a href="admin_add_questions.php">Add Questions</a>
<a href="admin_survey_link_questions.php">Link Questions to Surveys</a>
<a href="admin_view_survey_list.php">View Survey List/Results</a>
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

$con->close();
?>

Select the survey & hit "View Results" to see the results of the survey.  
<form  method="post" action="admin_view_survey_results.php">
<!-- Display List of Surveys in dropdown box -->
  <select name="survey_id_list">
<?php for ($i=1; $i<=$survey_count; $i++) 
	{?>
    <option value="<?php echo "$survey_id_array[$i]";?>"><?php echo "$survey_names_array[$i]";?></option>
    <?php 
	}?>
  </select>
  
  <br><br>
  <input type="submit"  value="View Results">
</form>

</body>
</html>



