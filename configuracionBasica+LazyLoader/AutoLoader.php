<?php
/*!
  * AutoLoader Class - Lazy
  * @autor Ignacio Gutierrez
  *
  * @param array $paths "Representa las rutas donde buscar las clases del autocargador lazy"
*/
class AutoLoader
{
	private static $paths;
	
	public function __construct($paths)
	{
		self::$paths = $paths;

		// Desactivo cualquier otro autoloader:
		if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
			spl_autoload_register(null, false);	
		}
	}

	public function __destruct(){
		self::$paths = NULL;
	}

	private static function lazyLoader($class)
	{
		foreach (self::$paths as $path)
		{
			$archivo = $path.$class.'.php';
			if (is_file($archivo))
			{
				require_once($archivo);
				return;
			}
		}
		throw new Exception("{$class} not found");
	}

	public function inicializar()
	{
		if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
		    // SPL autoloading fue introducido en PHP 5.1.2
		    if ( version_compare(PHP_VERSION, '5.3.0', '>=') ) {
		        spl_autoload_register('self::lazyLoader', true, true);
		    } else {
		        spl_autoload_register('self::lazyLoader');
		    }
		}
	}
}