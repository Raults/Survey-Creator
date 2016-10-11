<?php
include('Online_Surveys.dbconfig.inc');
?>


<html>
<head> USER HOMEPAGE
<title>

</title>
</head>
<body>
UserId: <?php echo $_SESSION['USER_ID']?>

<br/>
<a href="user_view_survey_list.php">List of Surveys</a>
</body>
</html>
