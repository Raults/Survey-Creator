<?php
include('Online_Surveys.dbconfig.inc');
?>


<html>
<head>
  <title>Vote+ (Admin Home)</title>
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
  <div id="greetings">Hello, Admin <?php echo $_SESSION['ADMIN_ID']?></div>
</body>
</html>
