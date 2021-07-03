<?php 
	/**
	 * This file needed for check bugs 
	 * and output info about variable
	 * 
	 * @package application\lib
	 * @category DeveloperLibrary
	 */
	ini_set("display_errors", 1);
	error_reporting(E_ALL);

	/**
	 * Output info about variable 
	 * which is specified as an argument
	 * 
	 * 
	 * @param  $value Some parameter
	 * 
	 * 
	 * @return string Some info
	 * about variable
	 * 
	 */
	function debug($value)
	{
		echo "<pre>";
		if(is_array($value)){

			var_dump($value);

		}else
		{
			echo $value;
		}
		echo "</pre>";

		exit;
	}

	function PhpArrayToDbArray($array, $key='')
	{
		$new_array = "{";
		foreach ($array as $val) {
			
			if ($key != '')
			{
				$new_array .= $val[$key].", ";
			}
			else
			{
				$new_array .= $val.", ";
			}
			
		}

		return substr($new_array, 0, count($new_array) - 3)."}";
	}
	function DbArrayToPhpArray($array)
	{
		
		$array = preg_replace("/\[0:[0-9]+\]=/", "", $array);
		$array = str_replace("{", "", $array);
		$array = str_replace("}", "", $array);
		$array = str_replace('"', "", $array);
		$array = explode(",", $array);
	
		return $array;
	}

	function RusToLat($string) {
    
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', '?', ':', '/', '\\', '|', '"');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '(7)', '(colon)', '(slash)', '(reverse_slash)', 'vertical_slash', '(double_quotes)');

        $string = str_replace(" ","_",$string);
        return str_replace($rus, $lat, $string);
    
	}
	function removeDir($path) {
  		
  		if (is_file($path)) return unlink($path);
  		
  		if (is_dir($path)) {
    		foreach(scandir($path) as $p) if (($p!='.') && ($p!='..'))
      			removeDir($path.DIRECTORY_SEPARATOR.$p);
    			return rmdir($path); 
    	}
  			return false;
  	}
  	function getMonth($number, $forChart=false)
	{
		$months = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];
		$monthsForChart = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
		if ($forChart == true)
		{
			return $monthsForChart[$number-1];
		}
		return $months[$number-1];
	}

 ?>