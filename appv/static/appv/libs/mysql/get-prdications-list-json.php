<?php

function tablejson(){
    $mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );

    $mysqli->set_charset("utf8");
    if ($mysqli->connect_error) 
    {
        header('Location: admin-login.php');
    }

    $TableContent = "";
    $table = array();

    if ( !empty($mysqli) )
    {
      $sql = "SELECT * FROM `predications` ORDER BY `id` DESC";
      $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

      //Fetch into associative array
      $first = true;
      while ( $row = $sql_resp->fetch_assoc())  
      {
        
        $table[] = $row;
      }


    }
    else
    {
      header('Location: admin-404.php');
      exit();
    }


    echo json_encode($table);

}


?>