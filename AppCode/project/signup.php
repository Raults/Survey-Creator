<script language="Javascript">
function IsEmpty()
{ 
	if(document.forms['theForm'].user_first_name.value == "")
	{
		alert("First name is required!");
		return false;
	}
	if(document.forms['theForm'].email_address.value == "")
	{
		alert("Email address is required!");
		return false;
	}
	if(document.forms['theForm'].user_pass.value == "")
	{
		alert("Password is required!");
		return false;
	}
  	if(document.forms['theForm'].user_pass.value != document.forms['theForm'].user_pass2.value)
	{
		alert("Password mismatch!");
		return false;
	}
	document.theForm.submit();
    return true;
}
</script>

<html>
  <head>
    <title>Vote+ (Sign Up)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/login.css"/>
    <link rel="stylesheet" href="css/signUp.css"/>
  </head>
  <body>
   <!-- <div id="nav">
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
    <div class=container>
      <div id="signUp">
        <div id="signUpTitle">Sign up ...</div>
        <form id = "signUpForm"  method="post" class="form-inline" name="theForm" action="signup.php">
          <div class="form-group row">
              <input type="text" class="form-control" name="user_first_name" placeholder="First name">
              <input type="text" class="form-control" name="user_last_name" placeholder="Last name">
          </div><br>
          <div class="form-group row">
            <input type="text" class="form-control" name="birth_date" placeholder="Birthdate">
            <input type="text" class="form-control" name="gender" placeholder="Gender">
          </div><br>
          <div class="form-group row">
            <input type="text" class="form-control" name="telephone_1" placeholder="Primary phone #">
            <input type="text" class="form-control" name="telephone_2" placeholder="Secondary phone #">
          </div><br>
          <div class="form-group row">
            <input type="text" class="form-control" name="address_line_1"placeholder="Street Address">
            <input type="text" class="form-control" name="city" placeholder="City">
          </div><br>
          <div class="form-group row">
            <input type="text" class="form-control" name="state" placeholder="State">
            <input type="text" class="form-control" name="zip" placeholder="Zip Code">
          </div><br><hr>
          <div class="form-group row">
            <input type="text" class="form-control" name="email_address" placeholder="Email address">
          </div><br>
          <div class="form-group row">
            <input type="password" class="form-control" name="user_pass" placeholder="Create password">
            <input type="password" class="form-control" name="user_pass2" placeholder="Confirm password">
          </div><br>
          <a href="index.php"><button type="button" id="backButton" class="btn btn-primary buttonSign row">Back</button></a>
          <button type="submit" id="submitButton" onclick="return IsEmpty();" class="btn btn-primary buttonSign row">Submit</button>
        </form>
      </div>
    </div>
	
	
<?php
#include('Online_Surveys.dbconfig.inc');

function NewUser()
{
	include('Online_Surveys.dbconfig.inc');	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password);
	if(!$conn)
	{
		die('Could not connect: ' . mysqli_error());
	}
	mysqli_select_db($conn, $dbname);
		
	#echo "<br>Test Insert <br>";
	$user_name = trim($_POST['email_address']);
	$user_first_name = trim($_POST['user_first_name']);
	$user_last_name = trim($_POST['user_last_name']);
	$user_pass = trim($_POST['user_pass']);
	$birth_date = trim($_POST['birth_date']);
	$gender = trim($_POST['gender']);
	$address_line_1 = trim($_POST['address_line_1']);
	//$address_line_2 = trim($_POST['address_line_2']);
	$address_line_2 ="";
	$city = trim($_POST['city']);
	$state = trim($_POST['state']);
	$zip = trim($_POST['zip']);
	$telephone_1 = trim($_POST['telephone_1']);
	$telephone_2 = trim($_POST['telephone_2']);
	$email_address = trim($_POST['email_address']);
	
	$num_rows=0;
	$sql = "SELECT * FROM tbl_users WHERE user_name='$user_name'";
	$result = mysqli_query($conn, $sql);
	if ($row=mysqli_fetch_array($result))
	{
		$num_rows = mysqli_num_rows($result);
	} else 
	{
		echo "<br>" . $conn->error."<br>";
	}
	if ($num_rows != 0)
	{
		echo "This email already exists in the database! Please choose a different email address to register!";
		$conn->close();
		exit;
	}
	
	$sql = "INSERT INTO tbl_users values (null,'$user_name','$user_pass','$user_first_name','$user_last_name','$birth_date','$gender','$address_line_1','$address_line_2','$city','$state','$zip','$telephone_1','$telephone_2','$email_address')";
		
	if ($user_name!= "" && $user_pass!= "" && $user_first_name!= "")
	{
		// Try inserting this question into the tbl_questions.
		if ($conn->query($sql) == TRUE)
		{
			$user_id = $conn->insert_id;
			echo "<b>New user Created successfully. user_id: ".$user_id."<b>";
			echo "<b>: Redirecting to Login Page in 3 seconds...<b>";
			header('Refresh: 3;url=index.php');
		} else 
		{ 	// This question already exists in the tbl_questions,
			echo "<br>" . $conn->error."<br>";
			echo "This user already exists in the database!";
		}
	} else
	{
		echo "<br>Missing values <br>";
	}
	
	$conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	//if(isset($_POST['submit']))
	{
	  NewUser();
	}
}

echo "<br><br>";
	
?>
	
</body>
</html>
