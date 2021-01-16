<?php
// web.njit.edu/~pkl8/backend.php

$hostname = "sql.njit.edu";
$schema = "pkl8";
$user = "pkl8";
$database_password = "Mysqlpassword1.";


$dbc = mysqli_connect($hostname,$user,$database_password,$schema);
if (mysqli_connect_errno()){
	echo "Failed to connect to database: " . mysqli_connect_error();
}

mysqli_select_db($dbc,$schema);


//$ucid = "teacher";
//$password = "password";
$ucid = $_POST["ucid"];
$password = $_POST["password"];

$sql = "SELECT role, password  FROM users where ucid = '$ucid'";
$query_result = mysqli_query($dbc,$sql);
$row = mysqli_fetch_row($query_result);
$role = $row[0];
$hashed_password = $row[1];

if (password_verify($password,$hashed_password) && mysqli_num_rows($query_result) > 0){
	$response = array(
		"success" => "yes",
		"role" => $role
	);
}
else{
	$response = array(
		"success" => "no",
		"role" => ""
	);
}

echo json_encode($response);

mysqli_free_result($query_result);
mysqli_close($dbc);

?>
