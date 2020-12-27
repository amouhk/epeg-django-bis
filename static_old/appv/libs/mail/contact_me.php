<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
   
$name 			= strip_tags(htmlspecialchars($_POST['name']));
$email_address  = strip_tags(htmlspecialchars($_POST['email']));
$phone 			= strip_tags(htmlspecialchars($_POST['phone']));
$message 		= strip_tags(htmlspecialchars($_POST['message']));
   
// Mail to site admin 
$to = 'e.gobelins@gmail.com'; 
$email_subject = "Formulaire de contact:  $name";
$email_body    = "Nouveau message depuis le site <strong>epegobelins.net</strong>.\n\n";
$email_body   .= "Details du message :\n\n";
$email_body   .= "Nom: $name\n";
$email_body   .= "Email: $email_address\n";
$email_body   .= "Téléphone: $phone\n";
$email_body   .= "Message:\n$message\n";
$headers  = "From: contact@epegobelins.org\n";
$headers .= "Reply-To: $email_address";   

mail($to,$email_subject,$email_body,$headers);


//Mail to visitor (Accusé de reception)
$to = $email_address; 
$email_subject = "Confirmation d'envoi de votre message";
$email_body    = "Nous avons bien réçu votre message et vous répondrons prochainement.\n\n";
$email_body   .= "Details du message envoyé:\n\n";
$email_body   .= "Nom: $name\n";
$email_body   .= "Email: $email_address\n";
$email_body   .= "Téléphone: $phone\n";
$email_body   .= "Message:\n$message\n\n";
$email_body   .= "Pour l'<em>Eglise Protestante Evangélique aux Gobelins</em>\n";
$headers  = "From: no-reply@epegobelins.org\n";

mail($to,$email_subject,$email_body,$headers);


return true;         
?>
