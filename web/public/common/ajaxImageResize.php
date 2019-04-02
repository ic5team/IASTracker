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
$thumbWidth = 200;
$thumbHeight = 200;
$maxWidth = 2580;
$maxHeight = 2048;

$max_file_size = 5*1024*1024;	//5MB
$errors = array(1 => 'Ep! La imatge és massa gran', 
                2 => 'Ep! La imatge és massa gran', 
                3 => 'file upload was only partial', 
                4 => 'no file was attached');

$dto = new stdClass();

if(isset($_POST['image']))
{



	$nomOriginal = explode("/", $_POST['image']);
	$nomOriginal = $nomOriginal[count($nomOriginal) - 1];
	
	$partsNom = explode(".", $nomOriginal);
	$ext = strtoupper($partsNom[count($partsNom)-1]);

	if('JPG' == $ext || 'JPEG' == $ext)
	{

		$img = @imagecreatefromjpeg($uploadsDirectoryThumbs.$nomOriginal);
		$bigImg = @imagecreatefromjpeg($uploadsDirectoryGrans.$nomOriginal);

	}
	else if('PNG' == $ext)
	{
		//echo $uploadsDirectory."big".$name;
		$img = @imagecreatefrompng($uploadsDirectoryThumbs.$nomOriginal);
		$bigImg = @imagecreatefrompng($uploadsDirectoryGrans.$nomOriginal);

	}
	else
	{

		$img = NULL;

	}


	if($img)
	{

		$width = imagesx($img);
		$height = imagesy($img);
		
		$bigWidth = imagesx($bigImg);
		$bigHeight = imagesy($bigImg);

		
		
		$xImg = (intval($_POST['x']) / $width) * $bigWidth;
		$yImg =(intval($_POST['y']) / $height) * $bigHeight;
		$wImg = (intval($_POST['w']) / $width) * $bigWidth;
		$hImg =(intval($_POST['h']) / $height) * $bigHeight;
		
		$aspect_ratio = $hImg / $wImg;
		
		//Guardem dues imatges, una petita per ensenyar-la a la web i 
		//una de gran per fer la impressió
		$newWidth = $thumbWidth;
		$newHeight = $thumbWidth * $aspect_ratio;
		$newBigImg = imagecreatetruecolor($wImg, $hImg);
		imagecopyresampled($newBigImg, $bigImg, 0, 0, $xImg, $yImg, $wImg, $hImg, $wImg, $hImg);
		
		$newImg = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($newImg, $newBigImg, 0, 0, 0, 0, $newWidth, $newHeight, 
			$wImg, $hImg);
			
		imagejpeg($newBigImg, $uploadsDirectoryGrans.$nomOriginal, 75);
		imagejpeg($newImg, $uploadsDirectoryThumbs.$nomOriginal, 75);

		$dto->urlThumbs = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$uploadsURL.'thumbs/'.$nomOriginal;
		$dto->urlGrans = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$uploadsURL.'grans/'.$nomOriginal;
		
		

	}
	else
	{

		$dto->error = 'La imatge té un format invàlid! Ha de ser bmp, jpeg o png';

	}

}
else
{

	$dto->error = 'No s\'ha pujat cap imatge!';

}

echo json_encode($dto);

?>