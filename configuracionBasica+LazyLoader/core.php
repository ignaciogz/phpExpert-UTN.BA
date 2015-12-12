<?php require('AutoLoader.php') ?>

<?php
define('SECRET_KEY','');
define('ROOT_USER','');

define('PATH_CFG','');
define('PATH_CLS','');
define('PATH_CLS_BACKEND','');
define('PATH_LOG','');
define('PATH_VENDOR', PATH_CLS.'');

//Paths para el redimensionador:
define('PATH_IMG','');
define('PATH_IMG_R50x50',PATH_IMG.'r50x50/');
define('PATH_IMG_R150x150',PATH_IMG.'r150x150/');

//CARGADOR LAZY EVALUATION
	$paths =[	
				PATH_CLS, 
				PATH_CLS_BACKEND,
				PATH_CLS_BACKEND."fileUploader/",
				PATH_CLS_BACKEND."imageResizer/",
				PATH_VENDOR."fpdf/",
				PATH_VENDOR."phpmailer/"
			];
	$loader = new AutoLoader($paths);
	$loader->inicializar();