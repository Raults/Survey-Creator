<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {//don't forget to put the 'submit' into the html tag code as "name=submit" and so on for the other values like "user_name" and "user_pass"
if (empty($_POST['user_name']) || empty($_POST['user_pass'])) {
$error = "Username or Password is invalid";
}
else 
{
// Define $user_name and $user_pass
$user_name=$_POST['user_name'];
$user_pass=$_POST['user_pass'];
// Establishing Connection with Server by passing server_name, user_name and user_pass as a parameter
$connection = mysql_connect("localhost", "root", "");
// To protect MySQL injection for Security purpose
$user_name = stripslashes($user_name);
$user_pass = stripslashes($user_pass);
$user_name = mysql_real_escape_string($user_name);
$user_pass = mysql_real_escape_string($user_pass);
// Selecting Database
$db = mysql_select_db("tbl_users", $connection);//I think tbl_users is correct for this, unsure...
// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("select * from tbl_users where user_pass='$user_pass' AND user_name='$user_name'", $connection);
$rows = mysql_num_rows($query);
if ($rows == 1) {
$_SESSION['login_user']=$user_name; // Initializing Session, login_user basically the variable in the "if(isset($_SESSION['login_user'])){..." portion of our index.php
header("location: index.php"); // Redirecting To logged in index
} else {
$error = "Username or Password is invalid";
}
mysql_close($connection); // Closing Connection
}
}
?>