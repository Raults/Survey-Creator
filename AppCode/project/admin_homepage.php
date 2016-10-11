<?php
include('Online_Surveys.dbconfig.inc');
?>


<html>
<head> ADMIN HOMEPAGE
<title>

</title>
</head>
<body> 
AdminId: <?php echo $_SESSION['ADMIN_ID']?>
<br/>
<a href="admin_create_survey.php">Create Survey</a>
<a href="admin_add_questions.php">Add questions</a>
<a href="admin_survey_link_questions.php">Link questions to surveys</a>
<a href="admin_view_survey_list.php">View Survey List/Results</a>

</body>
</html>



