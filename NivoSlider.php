<?php

/**
 * @copyright Copyright &copy; Amilna, amilna.net, 2015
 * @package yii2-yap
 */

namespace amilna\yap;

/**
 * Widget renders a Nivo Slider widget.
 *
 * For example:
 *
 * use amilna\nivoslider\NivoSlider;
 * 
 * echo NivoSlider::widget([
 * 		'dataProvider'=>$dataProvider, // active data provider or just array of image,url, title and description, exp: [["image"=>"test1.jpg","url"=>null],["image"=>"test2.jpg","url"=>null]]
 * 		'targetId'=>'nivoslider',	//id of rendered nivoslider (the container will constructed by the widget with the given id)		
 * 		'imageKey'=>'image', //model attribute to be used as background
 * 		'theme' => 'default', //available themes: default, bar, dark, light
 *  	'css' => '', // url of css to overide default css relative from @web	  		
 * 		
 * 		
 * 		//	example to overide default options	more options on http://docs.dev7studios.com/jquery-plugins/nivo-slider
 * 		'options'=>[
 * 				'effect'=> 'boxRandom',
 * 				'manualAdvance'=>false,
 * 				'controlNav'=> false				
 * 			],		
 * 		 						
 * 	]); 
 *
 * @author Amilna
 * @see https://github.com/gilbitron/Nivo-Slider
 * @package amilna\nivoslider
 */
 
class NivoSlider extends \amilna\nivoslider\NivoSlider
{
}
