<?php

// get the parameter q from URL
$idpred=$_REQUEST["idpred"];
$js_code="";


$mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );

$mysqli->set_charset("utf8");
if ($mysqli->connect_error) 
{
	$js_code="";
}

if ( !empty($mysqli) )
{
  $sql = "SELECT * FROM `predications` WHERE `predications`.`id` = $idpred";
  $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

  $row = $sql_resp->fetch_assoc();

  //create javascript code
	$js_code .=			  '<script type="text/javascript">'
							.'//<![CDATA['
							.'$(document).ready(function(){'
							  .'$("#jquery_jplayer_1").jPlayer({'
							    .'ready: function () {'
							      .'$(this).jPlayer("setMedia", {'
							        .'title: "Bubble",'
							        .'mp3: "http://jplayer.org/audio/mp3/Miaow-07-Bubble.mp3"'
							      .'});'
							    .'},'
							    .'swfPath: "../../dist/jplayer",'
							    .'supplied: "mp3",'
							    .'wmode: "window",'
							    .'useStateClassSkin: true,'
							    .'autoBlur: false,'
							    .'smoothPlayBar: true,'
							    .'keyEnabled: true,'
							    .'remainingDuration: true,'
							    .'toggleDuration: true'
							  .'});'
							.'});'
							.'//]]>'
							.'</script>';

}

$mysqli->close();
echo $js_code;
?>