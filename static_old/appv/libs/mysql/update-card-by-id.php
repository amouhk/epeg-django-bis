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
    header('Location: /admin-index.php');
}

$updId = $_SESSION['IDPRED'];
//echo $updId.'<br/>';

if (isset($_POST) && !empty($_POST['titre']) && !empty($_POST['message']) ) 
{
    extract($_POST);
 } 
 else
 {
    exit();
 }

 //echo $titre.'<br/>';
 //echo $message.'<br/>';
 $annonce = htmlentities($_POST['message']);

 //echo $annonce.'<br/>';

if ( !empty($mysqli) )
{
  $sql = "UPDATE `activites` SET `libelle`= '$titre',`annonce`= '$message' WHERE `activites`.`id` = $updId";
  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

  //$row = $sql_resp->fetch_assoc();

  header('Location: /admin-index.php');

}
else
{
  header('Location: admin-404.php');
  exit();
}

$mysqli->close();
?>