<?php

// On prolonge la session
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['USER'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: admin-404.php');
  exit();
}

$mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );

$mysqli->set_charset("utf8");
if ($mysqli->connect_error) 
{
    header('Location: admin-login.php');
}

$updId = $_SESSION['IDPRED'];

if (isset($_POST) && !empty($_POST['titre']) && !empty($_POST['predicateur']) 
    && !empty($_POST['inputDescr']) && !empty($_POST['date']) && !empty($_POST['inputTypeMsg']) ) 
{
    extract($_POST);
 } 
 else
 {
    exit();
 }


 // echapper les chaines de caractères
$titre        = mysqli_real_escape_string($mysqli, $titre);
$predicateur  = mysqli_real_escape_string($mysqli, $predicateur);
$inputDescr   = mysqli_real_escape_string($mysqli, $inputDescr);
$inputTypeMsg = mysqli_real_escape_string($mysqli, $inputTypeMsg);


if ( !empty($mysqli) )
{
  $sql = "UPDATE `predications` SET `titre` = '$titre', `predicateur` = '$predicateur', `type` = '$inputTypeMsg' ,`date` = '$date', `description` = '$inputDescr' WHERE `predications`.`id`= $updId";
  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

  //$row = $sql_resp->fetch_assoc();

  header('Location: /admin-tables.php');

}
else
{
  header('Location: admin-404.php');
  exit();
}

$mysqli->close();
?>