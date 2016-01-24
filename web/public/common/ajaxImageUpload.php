<?php

/*!
Script utilitzat per pujar imatges al servidor mitjançant AJAX
Retorna un DTO amb els següents camps:
	url -> Adreça de la imatge provisional en el servidor
	error -> Missatge d'error si n'hi ha hagut algun
*/

$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

$uploadsDirectoryThumbs = '../img/uploads/thumbs/';
$uploadsDirectoryGrans = '../img/uploads/grans/';
$uploadsURL = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/img/uploads/';
$fieldName = 'image'; 
$thumbWidth = 450;
$thumbHeight = 300;
$maxWidth = 2580;
$maxHeight = 2048;

$max_file_size = 5*1024*1024;	//5MB
$errors = array(1 => 'Ep! La imatge és massa gran', 
                2 => 'Ep! La imatge és massa gran', 
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
				if(@getimagesize($_FILES[$fieldName]['tmp_name']))
				{
					$name = $_FILES[$fieldName]["name"];
					$partsNom = explode(".", $name);
					$ext = strtoupper($partsNom[count($partsNom)-1]);

					if('JPG' == $ext || 'JPEG' == $ext)
					{
						$img = @imagecreatefromjpeg($_FILES[$fieldName]['tmp_name']);
					}
					else if('PNG' == $ext)
					{
						$img = @imagecreatefrompng($_FILES[$fieldName]['tmp_name']);
					}
					else
					{
						$img = NULL;
					}

					if($img)
					{
						
						$width = imagesx($img);
	      				$height = imagesy($img);
						$aspectratio = $height / $width;

	      				//Guardem dues imatges, una petita per ensenyar-la a la web i 
	      				//una de gran per fer la impressió
	      				$newWidth = $thumbWidth;
	      				$newHeight = $thumbWidth * $aspectratio;
	      				$tmpImg = imagecreatetruecolor($newWidth, $newHeight);
	      				imagecopyresized($tmpImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, 
	      					$width, $height);

						$key = '';
						$keys = array_merge(range(0, 9), range('a', 'z'));

						for ($i = 0; $i < 10; $i++) {
							$key .= $keys[array_rand($keys)];
						}

	      				$imageName = $key.'.jpg';
	      				imagejpeg($tmpImg, $uploadsDirectoryThumbs.$imageName, 75);

	      				$dto->url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$uploadsURL.'thumbs/'.$imageName;

	      				$tmpImg = imagecreatetruecolor($width, $height);
	      				imagecopyresized($tmpImg, $img, 0, 0, 0, 0, $width, $height, 
	      					$width, $height);
	      				imagejpeg($tmpImg, $uploadsDirectoryGrans.$imageName, 75);

					}
					else
					{

						$dto->error = 'La imatge té un format invàlid! Ha de ser jpeg o png';

					}

				}
				else
				{

					$dto->error = 'Ep! El fitxer sembla que no és una imatge!';

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
	$dto->error = 'No s\'ha pujat cap imatge!';
	
}




echo json_encode($dto);

?>