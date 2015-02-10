<?php

/**
 * @copyright Copyright &copy; Amilna, amilna.net, 2015
 * @package yii2-yap
 */

namespace amilna\yap;

/**
 * Widget renders a Sequence JS widget.
 *
 * For example:
 *
 * ```php
 *  use amilna\yap\SequenceJs;
 *  echo SequenceJs::widget([
 *		'dataProvider'=>$dataProvider, // active data provider
 *		'targetId'=>'sequence',	//id of rendered sequencejs (the container will constructed by the widget with the given id)
 *		'imageKey'=>'front_image', //model attribute to be used as image
 *		'backgroundKey'=>'image', //model attribute to be used as background
 *		'theme' => 'parallax', //available themes: default, parallax, modern
 * 
 *		'css' => 'test.css', // url of css to overide default css relative from @web	
 *  
 *		// example to overide default themes
 *		'itemView'=>function ($model, $key, $widget) {					
 *						$type = ['aeroplane','balloon','kite'];
 *						$html = '<li>
 *									<div class="info">
 *										<h2>'.$model->title.'</h2>
 *										<p>'.$model->description.'</p>
 *									</div>
 *									<img class="sky" src="'.$model->image.'" alt="Blue Sky" />
 *									<img class="'.$type[$key%3].'" src="'.$model->front_image.'" alt="Aeroplane" />
 *								</li>';
 *										
 *						return $html;
 *					}, 
 *		
 *		
 *		//	example to overide default options	more options on http://sequencejs.com
 *		'options'=>[
 *				'autoPlay'=> true,
 *				'autoPlayDelay'=> 3000,
 *				'cycle'=>true,						
 *				'nextButton'=> true,
 *				'prevButton'=> true,
 *				'preloader'=> true,
 *				'navigationSkip'=> false
 *			],
 *		
 *		//	example to use widget without active data provider (the target selector should already rendered)
 *		'targets' => [
 *			'.sequencejs' => [
 *				'autoPlay'=> true,
 *				'autoPlayDelay'=> 3000,
 *				'cycle'=>true,						
 *				'nextButton'=> true,
 *				'prevButton'=> true,
 *				'preloader'=> true,
 *				'navigationSkip'=> false
 *			],
 *		],
 *		 						
 * 	]); 
 * ```
 *
 * @author Amilna
 * @see http://www.sequencejs.com/
 */
 
class SequenceJs extends \amilna\sequencejs\SequenceJs
{
}
