<?php
/**
 * @link https://github.com/amilna/yii2-yap
 * @copyright Copyright (c) 2015 Amilna
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace amilna\yap;

use Yii;
use yii\web\AssetBundle;

class BeautifyAsset extends AssetBundle
{
    public $sourcePath = '@amilna/yap/assets';
	
	public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public function init()
    {
        parent::init();

        $this->js[] = 'js/beautify.min.js';               
    }    
}
