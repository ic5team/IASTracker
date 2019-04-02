<?php

/*!
Script utilitzat per pujar imatges al servidor mitjançant AJAX
Retorna un DTO amb els següents camps:
	url -> Adreça de la imatge provisional en el servidor
	error -> Missatge d'error si n'hi ha hagut algun
*/

$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

$uploadsDirectory = '../shapes/';
$uploadsURL = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/shapes/';
$fieldName = 'zip'; 

$max_file_size = 1*1024*1024;	//1MB
$errors = array(1 => 'Ep! El fitxer és massa gran', 
                2 => 'Ep! El fitxer és massa gran', 
                3 => 'file upload was only partial', 
                4 => 'no file was attached');

$dto = new stdClass();

if(isset($_FILES[$fieldName]))
{
	if(0 == ($_FILES[$fieldName]['error']))
	{
		if($_FILES[$fieldName]['size'] <= $max_file_size)
		{
			if(@is_uploaded_file($_FILES[$fieldName]['tmp_name']))
			{
				
				$name = $_FILES[$fieldName]["name"];
				$partsNom = explode(".", $name);
				$ext = strtoupper($partsNom[count($partsNom)-1]);

				if('ZIP' == $ext || 'zip' == $ext)
				{

					$key = '';
					$keys = array_merge(range(0, 9), range('a', 'z'));

					for ($i = 0; $i < 10; $i++) {
						$key .= $keys[array_rand($keys)];
					}


      				$fileName = $key.'.zip';
					rename($_FILES[$fieldName]['tmp_name'], $uploadsDirectory.$fileName);
					$dto->url = 'shapes/'.$fileName;

				}
				else
				{

					$dto->error = 'Ep! El fitxer no és un ZIP!';

				}

			}
			else
			{

				$dto->error = 'No és un fitxer que haguem pujat';

			}

		}
		else
		{

			$dto->error = 'Ep! El fitxer és massa gran!';

		}

	}
	else
	{

		$dto->error = $errors[$_FILES[$fieldName]['error']];

	}

}
else
{
	$dto->error = 'No s\'ha pujat cap fitxer!';
	
}




echo json_encode($dto);

?>