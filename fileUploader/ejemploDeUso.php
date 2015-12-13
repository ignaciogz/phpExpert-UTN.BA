<?php require 'FileUploader.php' ?>

<?php 
	$nombre = $_POST['nombreProducto'];	
	
	//TRABAJANDO CON LA IMAGEN:
	$nImagen= str_replace(" ", "_", $nombre);
		
		if( $_FILES['cargadorDeImagen']['tmp_name']!="" )
		{
			$a		= $_FILES['cargadorDeImagen']['name'];
			$d		= "catalogo/";	
			$e		= array("jpg");
			$t		= $_FILES['cargadorDeImagen']['size'];
			$tmp	= $_FILES['cargadorDeImagen']['tmp_name'];
			
			$imagen = new FileUploader($a,$d,$e,$t,$tmp, $nImagen);	
			$imagen->upLoadFile();
		}