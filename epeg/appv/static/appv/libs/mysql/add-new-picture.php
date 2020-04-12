<?php

error_reporting(E_ALL);

// On prolonge la session
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['USER'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: admin-login.php');
  exit();
}

$mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );

$mysqli->set_charset("utf8");
if ($mysqli->connect_error) 
{
    header('Location: /admin-login.php');
}

// we first include the upload class, as we will need it here to deal with the uploaded file
include('../class/upload/src/class.upload.php');

// set variables
$dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : '/home/epegobel/public_html/ressources/gallery');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

$log = '';

$html_log = '';

$html_log .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$html_log .= '<html xmlns="http://www.w3.org/1999/xhtml">';
$html_log .= '<meta http-equiv=content-type content="text/html; charset=UTF-8">';
$html_log .= '<head>';
$html_log .= '    <title>class.php.upload test forms</title>';
$html_log .= '    <style>';
$html_log .= '        body {';
$html_log .= '        }';
$html_log .= '        p.result {';
$html_log .= '          width: 50%;';
$html_log .= '          margin: 15px 0px 25px 0px;';
$html_log .= '          padding: 0px;';
$html_log .= '          clear: right;';
$html_log .= '        }';
$html_log .= '        img {';
$html_log .= '          float: right;';
$html_log .= '          background: url(bg.gif);';
$html_log .= '        }';
$html_log .= '        fieldset {';
$html_log .= '          width: 50%;';
$html_log .= '          margin: 15px 0px 25px 0px;';
$html_log .= '          padding: 15px;';
$html_log .= '        }';
$html_log .= '        legend {';
$html_log .= '          font-weight: bold;';
$html_log .= '        }';
$html_log .= '        fieldset p {';
$html_log .= '          font-size: 70%;';
$html_log .= '          font-style: italic;';
$html_log .= '        }';
$html_log .= '        .button {';
$html_log .= '          text-align: right;';
$html_log .= '        }';
$html_log .= '        .button input {';
$html_log .= '          font-weight: bold;';
$html_log .= '        }';
$html_log .= '    </style>';
$html_log .= '</head>';
$html_log .= '<body>';
$html_log .= '    <h1>class.upload.php test forms</h1>';



$str_id = '';
// Get table last id
if ( !empty($mysqli) )
{
    
    $sql = "SELECT * FROM `galeries` ORDER BY id DESC LIMIT 0, 1";
    $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
    $row = $sql_resp->fetch_assoc();
    
    $num = $row['id'] + 1;
    $str_length = 5;
    $str_id = substr("0000{$num}", -$str_length);
    
    $html_log .= '<br> Last id : ' . $str_id;
}


// we have several forms on the test page, so we redirect accordingly
$album = (isset($_POST['album']) ? $_POST['album'] : (isset($_GET['album']) ? $_GET['album'] : 'Autre'));
$action = (isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : ''));

$html_log .= '<br> Album : ' . $album;

if ($action == 'simple') {

    // ---------- SIMPLE UPLOAD ----------

    // we create an instance of the class, giving as argument the PHP object
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new upload($_FILES['picture']);

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {

        // yes, the file is on the server
        // now, we start the upload 'process'. That is, to copy the uploaded file
        // from its temporary location to the wanted location
        // It could be something like $handle->process('/home/www/my_uploads/');
        //$dir_dest = $dir_dest ."/2018;
        $handle->file_src_name_body = 'IMAGE_' . $str_id;
        $dir_dest = $dir_dest ."/Photo/". $album;
        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            $db_file_path = substr($handle->file_dst_pathname, strlen('/home/epegobel/public_html/'));

            $html_log .=  '<p class="result">';
            $html_log .=  '  <b>File uploaded with success</b><br />';
            $html_log .=  '  File: <a href="'.$dir_pics.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
            $html_log .=  '<br> Database File :  ' . $db_file_path;
            $html_log .=  '<br> File name :  ' . $handle->file_src_name_body;
            $html_log .=  '<br> File ext  :  ' . $handle->file_src_name_ext;
            $html_log .=  '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            $html_log .=  '</p>';

            // update databse
            if ( !empty($mysqli) )
            {
                $sql = "INSERT INTO `galeries`(`id`, `name`, `type`, `album`, `filepath`) VALUES (NULL, '$handle->file_src_name_body', 'Photo', '$album', '$db_file_path')";

                $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

            }
            else
            {
              header('Location: /admin-index.php');
              exit();
            }

            $mysqli->close();



        } else {
            // one error occured
            $html_log .=  '<p class="result">';
            $html_log .=  '  <b>File not uploaded to the wanted location</b><br />';
            $html_log .=  '  Error: ' . $handle->error . '';
            $html_log .=  '</p>';
        }

        // we delete the temporary files
        $handle-> clean();

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        $html_log .=  '<p class="result">';
        $html_log .=  '  <b>File not uploaded on the server</b><br />';
        $html_log .=  '  Error: ' . $handle->error . '';
        $html_log .=  '</p>';
    }

    $log .= $handle->log . '<br />';


} 

$html_log .=  '<p class="result"><a href="index.html">do another test</a></p>';
$html_log .=  '<pre>' . $log . '</pre>';
$html_log .=  '</body>';
$html_log .=  '</html>';

//echo $html_log;
header('Location: /admin-index.php');

?>