<?php
session_start();
$_SESSION['start']=1;
?>

<html>
  <head>
    <title>Vote +</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/login.css"/>
  </head>
  <body>
     <div id="nav">
      <!--
      <ul class="pull-left">
        <li class="buttonNav"><a href="index.html">HOME</a></li>
        <li>/</li>
        <li class="buttonNav"><a href="survey.html">TAKE SURVEY</a></li>
        <li>/</li>
        <li class="buttonNav"><a href="profile.html">PROFILE</a></li>
      </ul>-->
      <div id="logo"><a href="#"><img src="img/voteLogo.png" height="35" width="62.2"></a></div>
      <!--
      <ul class="pull-right">
        <li class="buttonNav"><a href="login.html">LOGIN / SIGNUP</a></li>
      </ul>-->
    </div>

	<!-- Login Form -->
    <div class=container>
      <div id ="login">
        <div id="loginTitle">Log in ...</div>
        <form id = "loginForm" class="form-inline" method="post" action="login_authenticate.php">
          <div class="form-group row">
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
          </div><br>
          <div class="form-group row">
            <label class="sr-only" for="exampleInputPassword3">Password</label>
            <input type="password"  name="password" class="form-control" id="password" placeholder="Password">
          </div><br>

			<!--Display incorrect login message-->
			<center>
			<?php /*if (isset($_SESSION['ADMIN_LOGGED_IN']) || isset($_SESSION['USER_LOGGED_IN']))
			{
				if($_SESSION['ADMIN_LOGGED_IN']==0 && $_SESSION['USER_LOGGED_IN']==0)
					echo "Enter email/ password!";
			}*/
			//if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				if(isset($_SESSION['IS_VALID_LOGIN']) && $_SESSION['IS_VALID_LOGIN']==0) echo"Incorrect username/ password!";
			}
			?>
			</center>
			<br>
          <!--<div class="checkbox row">
            <label>
              <input type="checkbox"> Remember me
            </label>
          </div><br>-->
          <button type="submit" class="btn btn-primary buttonSign row">Sign in</button>
        </form><hr>
        <div id ="signUpLink"><a href="signup.php"> Create account</a></div>
      </div>


    </div>

  </body>
</html>
