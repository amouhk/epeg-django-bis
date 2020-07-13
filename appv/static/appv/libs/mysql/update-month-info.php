<?php

// On prolonge la session
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['USER'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: /admin-404.php');
  exit();
}

$mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );

$mysqli->set_charset("utf8");
if ($mysqli->connect_error) 
{
    header('Location: /admin-login.php');
}

$updId = $_SESSION['IDPRED'];

if (isset($_POST) && !empty($_POST['nbWeek']) && !empty($_POST['curWeek'])) 
{
    extract($_POST);
 } 
 else
 {
    exit();
 }


if ( !empty($mysqli) )
{
  if ( $curWeek <= $nbWeek && $nbWeek <= 5 && $curWeek <= 5)
  {
    $sql = "UPDATE `semaines` SET `nb_week` = '$nbWeek', `current_week_id` = '$curWeek' WHERE `semaines`.`id` = 1;";
    $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
  }
  //$row = $sql_resp->fetch_assoc();

  header('Location: /admin-index.php');

}
else
{
  header('Location: /admin-404.php');
  exit();
}

$mysqli->close();
?>