<?php
session_start();
$host="localhost"; // Host name
$username="root"; // Mysql username
$password="1Got1Udont!@"; // Mysql password
$db_name="bsds"; // Database name
$tbl_name="account"; // Table name

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect");
//mysql_select_db("$db_name")or die("cannot select DB");

// Define $myusername and $mypassword
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysqli_real_escape_string($conn,$myusername);
$mypassword = mysqli_real_escape_string($conn,$mypassword);

$sql = "SELECT * FROM account WHERE username='$myusername' AND password='$mypassword';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);



//echo "lampas line 28";

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row



if($count==1){

$username = $row['username'];

session_start();
$_SESSION['loggedin'] = true;
$_SESSION['username'] = $username;

echo "HELLO WORLD";
header ('location: index.php');

}

else{
	//$message = "Wrong username or password!";
	
	header ('location: login.html');
	//echo '<script>alert('.$message.')</script>';
	
}
?>