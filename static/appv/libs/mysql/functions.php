<?php

function user_upload_file($input_name, &$dest_path, $supported_types, &$db_log)
{
	$db_log .= "[INFO] : **** Begin upload ". $input_name ." **** ".PHP_EOL;
	$uploadOk = 1;

	if ($_FILES[$input_name]["error"] > 0)
	{
	  $db_log .= '[ERROR] : File '.$_FILES[$input_name]["error"] . " is not being upload ".PHP_EOL;
	  $uploadOk  = 0;
	}
	else 
	{
	  $filename = basename( $_FILES[$input_name]["name"]);
	  $db_log .= '[INFO] : filename is '.$filename.PHP_EOL;
	  $date   = substr($filename, 0, 4);
	  $dir    = $dest_path.'/'.$date;
	  if (!file_exists($dir)) {
	      mkdir($dir , 0777);
	  }
	  $target_file_path = $dir.'/'.$filename;
	  $db_log .= '[INFO] : Destination file path is '.$target_file_path.PHP_EOL;

	  //database file path output
	  $dest_path = $target_file_path;

	  // Check if file already exists
	  // remove old file
	  if (file_exists($target_file_path)) 
	  {
		  $db_log   .= "[WARNING] : Sorry, file already exists. File will be overwrite".PHP_EOL;
		  //$db_log   .= ( unlink($target_file_path) ) ? "[INFO] : Success Removing Existing file".PHP_EOL : "[ERROR] : Fail to remove existing file".PHP_EOL;
		  //$uploadOk  = 0; 
	  }

	  // Allow certain file formats
	  $uploadFileType = strtolower(pathinfo($target_file_path, PATHINFO_EXTENSION));
	  $db_log .= 'Input file type is '.$uploadFileType.PHP_EOL;
	  if ( !in_array($uploadFileType, $supported_types) ) {
		 $db_log  .= '[ERROR] : File type '.$uploadFileType.' is not supported.'.PHP_EOL;;
		 $uploadOk = 0;
	  }
	  

	  // Move upload file
	  if ($uploadOk)
	  {
		$uploadOk = @move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file_path);

		if ($uploadOk)
			$db_log .= "[INFO] : The file ".$target_file_path.' is correctly copied '.PHP_EOL;
		else
			$db_log .= "[ERROR] : Can't copy file ".$target_file_path.PHP_EOL;;
	  } 

      $db_log .= "[INFO] : Upload status : ".$uploadOk.PHP_EOL;
	}
	
	$db_log .= "[INFO] : **** End upload " .$input_name ." **** ".PHP_EOL;
	
	return $uploadOk;
}

?>
