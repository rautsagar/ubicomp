<?php
ob_start();
require_once("db_conn.php");

$username = $_POST['username'];
// $password = md5($_POST['passwd']);
$password = $_POST['passwd'];

// echo $username . ' ' . $password;
// echo "<br />";

// sending query
$result = mysql_query("SELECT * FROM faculty WHERE username = '" . $username . "' AND password = '" . $password . "'");
if (!$result) {
    die("Error");
}

$count = mysql_num_rows($result);

if($count == 0)
{
	echo "Invalid username & password <br />";
	echo "<a href = 'login.php'>Try Again</a>";
}
else if ($count == 1)
{
	session_start();
	echo "Successful Login";
	setcookie('uname', $username , time()+60*60*24, '/');
	header("Location: index.php");
}
ob_flush();
?>
