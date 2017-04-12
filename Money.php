<?php

namespace amilna\yap;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

use amilna\yap\MoneyAsset;

/**
 * This is just an example.
 */
class Money extends InputWidget
{
    public $name;
    public $value = 0;
    public $pluginOptions = [
			 "radixPoint"=>".", 
			 "groupSeparator"=> ",", 
			 "digits"=> 2,
			 "autoGroup"=> true,
			 "prefix"=> ''
		 ];
		 
	public $pluginEvents = [];	     
		 
	private $_displayOptions = [];	 

    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'form-control');
        Html::addCssClass($this->options, 'yap-money');
        $this->_displayOptions = $this->options;
        $this->_displayOptions['id'] .= '-disp';
        if (isset($this->_displayOptions['name'])) {
            unset($this->_displayOptions['name']);
        }
        
        $this->registerAssets();
        
        if ($this->hasModel())
        {
			$model = $this->model;
			$atr = $this->attribute;
			if (empty($model->$atr))
			{
				$model->$atr = 0;	
			}			
			$this->value = $model->$atr;
		}
                
        $input = Html::textInput($this->name, $this->value, $this->_displayOptions);
        $input .= $this->hasModel() ?
            Html::activeHiddenInput($this->model, $this->attribute) :
            Html::hiddenInput($this->name, $this->value);
                
		echo $input;
        
    }

    public function run()
    {
        $view = $this->getView();
        $model = $this->model;
        $idModel = strtolower($model->formName());
        $inputId = $this->attribute;        

        $options = json_encode($this->pluginOptions);
		
		$modelId = strtolower($idModel."-".$inputId);
		
		$ts = $this->pluginOptions["groupSeparator"];		
		$ds = $this->pluginOptions["radixPoint"];
		$ps = $this->pluginOptions["prefix"];				
		
		$js2= "";
		$evs = "";
		foreach ($this->pluginEvents as $en=>$ev)
		{
			$js2 .= '           
			   $("#'.$modelId.'").'.$en.'('.$ev.');
			';
			$evs .= '$("#'.$modelId.'").trigger("'.$en.'");';		
		}
		
        $js = <<<SCRIPT
           $("#$modelId-disp").inputmask("decimal",$options);
		   $("#$modelId-disp").change(function(){
				var val = parseFloat($("#$modelId-disp").val().replace("$ps","").replace(/\\$ts/g,"").replace(/\\$ds/g,"."));
				val = (isNaN(val)?0:val);				
				$("#$modelId").val(val);
				$evs
		   });			    
SCRIPT;
		
		$view->registerJs($js2);
        $view->registerJs($js);
        
        
        

    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        MoneyAsset::register($view);
//
//        $attr = $this->attribute;
//        $js = <<<SCRIPT
//
//SCRIPT;
//
//        $view->registerJs($js);
    }
}
