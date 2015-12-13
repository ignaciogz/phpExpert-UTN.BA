<?php include 'ImageResize.php';?>

<?php
//EJEMPLO DE USO DE LA CLASE ImageResize:
	$nombreDeImagen = "imagenX";

	$src = PATH_IMG.$nombreDeImagen.".jpg";
	$dest1 = PATH_IMG_R50x50.$nombreDeImagen.".jpg";
	$dest2 = PATH_IMG_R150x150.$nombreDeImagen.".jpg";
	$imagen = new ImageResize($src);
		$imagen->resize(50,50);
	@$imagen->save($dest1);
		$imagen->resize(150,150);
	if (!@$imagen->save($dest2))
	{
	   echo "Archivo no fue generado. Error: " . error_get_last();
	}
	else 
	{
	   echo "Archivo $dest2 generado.";
	}