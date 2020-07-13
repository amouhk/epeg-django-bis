<?php

// get the parameter q from URL
$idpred=$_REQUEST["idpred"];


$mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );

$mysqli->set_charset("utf8");
if ($mysqli->connect_error) 
{
    //echo "exit()";
    exit();
}

if ( !empty($mysqli) )
{
  $sql = "SELECT * FROM `predications` WHERE `predications`.`id` = $idpred";
  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

  $row = $sql_resp->fetch_assoc();

 // JSON Row 
 $jsonData = json_encode($row);
 
 echo  $jsonData;
}

$mysqli->close();
//echo 'my predication id is :'.$idpred;
?>