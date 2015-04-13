<?php
/**
 * @link https://github.com/amilna/yii2-yap
 * @copyright Copyright (c) 2015 Amilna
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace amilna\yap;

use Yii;
use yii\web\AssetBundle;

class MoneyAsset extends AssetBundle
{
    public $sourcePath = '@amilna/yap/assets';
	
	public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
	
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        $this->js[] = 'js/jquery.inputmask.js';               
        $this->js[] = 'js/jquery.inputmask.numeric.extensions.js';               
        $this->js[] = 'js/jquery.inputmask.date.extensions.js';               
    }    
}
