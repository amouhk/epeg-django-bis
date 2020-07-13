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
    header('Location: /admin-login.php');
}

// extracttion des variable du formulaire
if (isset($_POST) && !empty($_POST['titre']) && !empty($_POST['predicateur']) 
    && !empty($_POST['inputDescr']) && !empty($_POST['date']) && !empty($_POST['inputTypeMsg'])) 
{
  extract($_POST);
} 
else
{
  exit();
}
//********************************

$LOGGER_FILE_PATH = '/home/epegobel/public_html/add_new_predication.log';
$LOG_HANDLER = fopen($LOGGER_FILE_PATH, 'w') or die('Cannot open file:  '.$LOGGER_FILE_PATH);
$log_collect ="";


$log_collect .= '[INFO] : Titre    = '.$titre.PHP_EOL;
$log_collect .= '[INFO] : Orateur  = '.$predicateur.PHP_EOL;
$log_collect .= '[INFO] : Descript = '.$inputDescr.PHP_EOL;
$log_collect .= '[INFO] : Date     = '.$date.PHP_EOL;
$log_collect .= '[INFO] : Type     = '.$inputTypeMsg.PHP_EOL;

// upload des fichiers de la predications (audio + ppt)
//include '../class/MP3File.php';
include 'functions.php';

$tag_name = "inputAudio";
$dest_dir = "/home/epegobel/public_html/ressources/audios";
$ftypes   = array("mp3", "wav", "ogg");

$tag_name_ppt = "inputPPT";
$dest_dir_ppt = "/home/epegobel/public_html/ressources/presentations";
$ftypes_ppt   = array("doc", "docm", "docx", "dot", "dotm", "dotx", "htm","html", "mht", "mhtml", "odt", "pdf", "PDF", "rtf", "txt", "WPS", "pot", "potm", "potx", "PPA", "ppam", "PPS", "PPSM", "ppsx", "ppt", "pptm", "pptx", "xls", "xlsx", "xlsm", "xlxt");

$is_audio_uploaded = user_upload_file($tag_name, $dest_dir, $ftypes, $log_collect);
$is_note_uploaded  = user_upload_file($tag_name_ppt, $dest_dir_ppt, $ftypes_ppt, $log_collect);

$db_file_path = substr($dest_dir, strlen('/home/epegobel/public_html/'));
$db_file_path_ppt = substr($dest_dir_ppt, strlen('/home/epegobel/public_html/'));

if(!$is_note_uploaded){
    $db_file_path_ppt = '';
    $log_collect .= '[WARNING] : No slides with this predication' .PHP_EOL;
}

$log_collect .= '[INFO] : Audio relatif path : ' . $dest_dir.PHP_EOL;
$log_collect .= '[INFO] : note relatif path : ' .  $dest_dir_ppt.PHP_EOL;
$log_collect .= '[INFO] : db audio file path : ' . $db_file_path .PHP_EOL;
$log_collect .= '[INFO] : db note file path : ' . $db_file_path_ppt .PHP_EOL;


if(!$is_audio_uploaded)
{
    $log_collect .= '[ERROR] : Audio file is missing' .PHP_EOL;
    fwrite($LOG_HANDLER, $log_collect);
    fclose($LOG_HANDLER);
    header('Location: /admin-tables.php');
    exit();
}

//Set bg-image
$artwork = '/ressources/images/logo/adorateur_design_051.jpg';

// echapper les chaines de caractères
$titre        = mysqli_real_escape_string($mysqli, $titre);
$predicateur  = mysqli_real_escape_string($mysqli, $predicateur);
$inputDescr   = mysqli_real_escape_string($mysqli, $inputDescr);
$inputTypeMsg = mysqli_real_escape_string($mysqli, $inputTypeMsg);

$log_collect .= '[INFO] : Titre    = '.$titre.PHP_EOL;
$log_collect .= '[INFO] : Orateur  = '.$predicateur.PHP_EOL;
$log_collect .= '[INFO] : Descript = '.$inputDescr.PHP_EOL;
$log_collect .= '[INFO] : Date     = '.$date.PHP_EOL;
$log_collect .= '[INFO] : Type     = '.$inputTypeMsg.PHP_EOL;


// update databse
if ( !empty($mysqli) )
{
  $sql = "INSERT INTO `predications` (`id`, `titre`, `predicateur`, `description`, `date`, `cheminFichier`, `type`, `artwork`, `cheminNotes`) VALUES (NULL, '$titre', '$predicateur', '$inputDescr', '$date', '$db_file_path', '$inputTypeMsg', '$artwork', '$db_file_path_ppt');";

  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
  
  $log_collect .= ($sql_resp == 1) ? '[INFO] : DataBase update Sucessed <br/>' : '[ERROR] : DataBase update Failed \n' ;
  fwrite($LOG_HANDLER, $log_collect);
  fclose($LOG_HANDLER);
  
  header('Location: /admin-tables.php');

}
else
{
  $log_collect .= '[INFO] : mysqli is empty' .PHP_EOL;
  fwrite($LOG_HANDLER, $log_collect);
  fclose($LOG_HANDLER);
  header('Location: /admin-404.php');
  exit();
}

$mysqli->close();
?>
