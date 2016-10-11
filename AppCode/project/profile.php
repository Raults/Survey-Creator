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

if ($_SESSION["ADMIN_LOGGED_IN"]==1)
{
	$userId=$_SESSION["ADMIN_ID"];
} else 
{
	$userId=$_SESSION["USER_ID"];
	#echo "<br>".$_SESSION["USER_ID"];
}
	echo "<br>\$_SESSION[\"USER_ID\"]:".$_SESSION["USER_ID"]." UserId:".$userId;

    $con = mysqli_connect($servername, $username, $password);
    if(!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
     
    mysqli_select_db($con, $dbname);
	$sql="SELECT * FROM tbl_users WHERE user_id=$userId";
    $result = mysqli_query($con, $sql);
	#echo "<br> sql:".$sql;
	
	// Numeric array
    while($row=mysqli_fetch_array($result,MYSQLI_NUM))
    {
		$user_name = $row['user_name'];
        $user_first_name = $row['user_first_name'];
        $user_last_name = $row['user_last_name'];
		$user_pass = $row['user_pass'];
		$birth_date = $row['birth_date'];
		$gender = $row['gender'];
		$address_line_1 = $row['address_line_1'];
		$address_line_2 = $row['address_line_2'];
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip'];
		$telephone_1 = $row['telephone_1'];
		$telephone_2 = $row['telephone_2'];
		$email_address = $row['email_address'];
    }
?>
<html>
//To add these values to html, simply post html code and format
//	here and then when you want the user value to show, type in
//	the value in a php echo like so: </?php echo $gender ?>.
//	The "/" after < is just ot break out of the php command.
</html>