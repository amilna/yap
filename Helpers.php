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
}
