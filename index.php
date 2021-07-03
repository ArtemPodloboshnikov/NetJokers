<?php 
	
	/**
	 * Source file which 
	 * runs everything else
	 * 
	 * @package ..
	 * @category StartPage
	 */
	require 'application/lib/Dev.php';
	require 'application/lib/HTMLTagInPHP.php';
	require 'application/lib/Markdown.php';
	require 'application/lib/PHPExcel.php';
	require 'application/lib/PHPExcel/Writer/Excel2007.php';
	require 'application/lib/PHPExcel/Settings.php';
	require 'application/lib/PHPUnit.php';
	require 'application/lib/Test.php';
	use application\core\Router;
	
	/**
	 * Auto-upload function 
	 * of modules
	 * 
	 * 
	 * 
	 * @param string $class Stores the path
	 *  to the connected class 
	 * 
	 * @return void Connects the php file 
	 * of the current class
	 */
	spl_autoload_register(
		function($class)
		{
			
			$path = str_replace('\\', '/', $class.".php");

			if (file_exists($path))
			{
				require $path;
			}

		});
	
	session_start();
	$_SESSION['constants'] = require 'application/config/constants.php';
	$router = new Router();
	$router->run();
	
 ?>