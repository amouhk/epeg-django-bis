<?php

// get the parameter q from URL
$id=$_REQUEST["id"];

$mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );

$mysqli->set_charset("utf8");
if ($mysqli->connect_error) 
{
    //echo "exit()";
    exit();
}

if ( !empty($mysqli) )
{
  
  $sql = "SELECT  COUNT(*) FROM `versets`"; 
  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
  $row = $sql_resp->fetch_assoc();
  $max = $row['COUNT(*)'];

  if ($id < 1 || $id > $max )
  {
  	$id = date("W", strtotime( date(DATE_RFC2822) ));
  }

  $sql = "SELECT * FROM `versets` WHERE `versets`.`id`=$id";
   
  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

  $row = $sql_resp->fetch_assoc();

 // JSON Row 
 $jsonData = json_encode($row);
 
 echo  $jsonData;
}

$mysqli->close();
?>
