<!-- Authenticates whether the user trying to login is admin or regular user. First checks if the user is listed in the tbl_admin, then checks if the user is listed in the tbl_users. 
1. Sets the following session variables to 1 or 0 accordingly
	$_SESSION["ADMIN_LOGGED_IN"]=1  # If the user logged in is admin user,
		or $_SESSION["USER_LOGGED_IN"]=1   # If the user logged in is regular user.
	
	$_SESSION["ADMIN_ID"] # Stores admin_id currently logged in.
	$_SESSION["USER_ID"] # Stores user_id currently logged in.

2. Sets the following variable to 0 or depending on if login was successfull or not.
$_SESSION["IS_VALID_LOGIN"]
-->

<?php
include('Online_Surveys.dbconfig.inc');

$_SESSION["IS_VALID_LOGIN"]= 0;
$_SESSION["ADMIN_ID"]= -1;
$_SESSION["USER_ID"]= -1;

	$con = mysql_connect($servername, $username, $password);
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db($dbname,$con);

	$nm=$_POST["email"];
	$pd=$_POST["password"];

	$admin_flag=0;
	$user_flag=0;
	$result = mysql_query("SELECT * FROM tbl_admin");
	while($row = mysql_fetch_array($result))
	{
		if($nm==$row[1] && $pd==$row[2])
		{
			$admin_flag=1;
			$_SESSION["ADMIN_ID"]= $row[0];
			$_SESSION["IS_VALID_LOGIN"]=1;
			#$_SESSION["n1"]=$row[1];
		break;
		}
	}
	
	$result = mysql_query("SELECT * FROM tbl_users");
	while($row = mysql_fetch_array($result))
	{
		if($nm==$row[1] && $pd==$row[2])
		{
			$user_flag=1;
			$_SESSION["USER_ID"]= $row[0];
			$_SESSION["IS_VALID_LOGIN"]=1;
			#$_SESSION["n1"]=$row[1];
		break;
		}
	}
	
	if($admin_flag==1)
	{			
			$_SESSION["ADMIN_LOGGED_IN"]=1;
			$_SESSION["USER_LOGGED_IN"]=0;		
	?>
	 
	<script type="text/javascript">
	 window.location="admin_homepage.php";
	</script>
	<?php
	} else if($user_flag==1)
	{			
			$_SESSION["USER_LOGGED_IN"]=1;
			$_SESSION["ADMIN_LOGGED_IN"]=0;
	?>
	<script type="text/javascript">
	 window.location="user_homepage.php";
	</script>
	<?php
	} else
	{
	$_SESSION["ADMIN_LOGGED_IN"]=0;
	$_SESSION["USER_LOGGED_IN"]=0;
	?>
	<script type="text/javascript">
		window.location="index.php";
	</script>
	<?php
	}
	?>
		