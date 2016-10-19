<?php

// Create connection
$db = mysqli_connect("localhost","F454Computing","WrXC2mcJaXzCQNwR", "communityhall");

//$db_found=mysql_select_db("communityhall");

//if($db_found){
//	print"DB FOUND";
//} else {
//	print"nope";
//}

// Check connection
if (mysqli_connect_errno($db))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


?>