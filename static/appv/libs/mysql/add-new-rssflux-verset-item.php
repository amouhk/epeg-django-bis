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

// extracttion des variable du formulaire
if (isset($_POST) && !empty($_POST['theme']) && !empty($_POST['title']) 
    && !empty($_POST['reference']) && !empty($_POST['verset']) ) 
{
  extract($_POST);
} 
else
{
  exit();
}

/*echo "t=".$theme.'<br/>';
echo "; p=".$title.'<br/>';
echo " ;d=".$reference.'<br/>';
echo " ;d=".$verset.'<br/>';*/

$date = date("Y-m-d");
$log_collect ="";

$theme = mysqli_real_escape_string($mysqli, $theme);
$title = mysqli_real_escape_string($mysqli, $title);
$verset    = mysqli_real_escape_string($mysqli, $verset);
$reference = mysqli_real_escape_string($mysqli, $reference);

$log_collect .= $theme . '<br>';
$log_collect .= $title . '<br>';
$log_collect .= $verset . '<br>';
$log_collect .= $reference . '<br>';
// update databse
if ( !empty($mysqli) )
{
  $sql = "INSERT INTO `versets` (`category`, `title`, `source`, `description`, `id`, `pubDate`) VALUES ('$theme', '$title', '$reference', '$verset', NULL, '$date')";

  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
 
  header('Location: /admin-index.php');

}
else
{
  header('Location: admin-404.php');
  exit();
}

//echo $log_collect;
$mysqli->close();
?>