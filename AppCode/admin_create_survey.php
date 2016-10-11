<?php
include('Online_Surveys.dbconfig.inc');

// define variables and set to empty values
$survey_nameErr = "";
$survey_name = $survey_description = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["survey_name"])) {
     $survey_nameErr = "Survey name is required";
   } else {
	   $survey_name=$_POST["survey_name"];
   }

   $survey_description=$_POST["survey_description"];
}
?>

<html>
<head>
  <title>Vote+ (Admin Create Survey)</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/login.css"/>
  <link rel="stylesheet" href="css/admin.css"/>
</head>
<body>
  <!--
<a href="admin_homepage.php">Admin Homepage</a>
<a href="admin_create_survey.php">Create Survey</a>
<a href="admin_add_questions.php">Add Questions</a>
<a href="admin_survey_link_questions.php">Add Questions to Surveys</a>
<br><br>-->
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
	<form id="createSurvey" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  Enter (Unique) Survey Name:
	  <input type="text" name="survey_name" value="<?php echo $survey_name;?>">
	  <!-- Check for Errors/ Empty Fields-->
		<?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($survey_name == "") { ?>
			<span class="error">* <?php echo $survey_nameErr;?></span>
		<?php } }?>
	   <br><br>

	  Enter Survey Description:
	  <input type="text" name="survey_description" value="<?php echo $survey_description;?>">
	  <br><br>

	  <!--Question Type:
	  <input type="text" name="question_content">
	  <br><br>-->

	  <input type="submit" value="Submit">
	  <br><br>
	</form>

<?php
if ($survey_name!= "") {

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO tbl_surveys VALUES (null, '$survey_name','$survey_description',null, null)";

if ($conn->query($sql) === TRUE) {
	$survey_id = $conn->insert_id;
    echo "New Survey Created successfully. SurveyId: ".$survey_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
echo "<br><br>";
}
?>


</body>
</html>
