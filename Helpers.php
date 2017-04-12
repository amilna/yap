<?php

/**
 * @copyright Copyright &copy; Amilna, amilna.co.id, 2016
 * @package yii2-yap
 */

namespace amilna\yap;
 
use yii\base\Component;

class Helpers extends Component
{
	public static function shellvar($string)
	{		
		return str_replace([";","&"], '', $string);		
	}
	
	public static function zipCreate($source,$destination) {
		$zip = new \amilna\yap\yZip();
		if (is_array($source))
		{
			$zip->zipFiles($source, $destination);	
		}
		else
		{
			$zip->zipDir($source, $destination);	
		}
		
		return file_exists($destination);
	}
	
	public static function zipExtract($source, $destination)
    {
		$zip = new \amilna\yap\yZip();
		$zip->unzip($source, $destination);
		
		return file_exists($destination);
	}
}
