<?php
  $db_host = '34.35.54.200';
  $db_user = 'root';
  $db_password = 'Nsateve2@';
  $db_db = 'recipe_sharing';
  $db_port = 3307;

  $conn = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db,
    $db_port
);
	
  if ($conn->connect_error) {
    echo 'Errno: '.$conn->connect_errno;
    echo '<br >';
    echo 'Error: '.$conn->connect_error;
    exit();
  }

?>