<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();
$relations = $generator->generateRelations();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;

/**
 * <?= $searchModelClass ?> represents the model behind the search form about `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{

	<?php
		foreach ($relations as $tab)
		{
			if ($tab) {
			echo "
	/*public \${$tab}Id;*/";	
			}
			
		}        
	?>


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
        ];
    }

	/* uncomment to undisplay deleted records (assumed the table has column isdel)
	public static function find()
	{
		return parent::find()->where([<?= isset($modelAlias) ? $modelAlias : $modelClass ?>::tableName().'.isdel' => 0]);
	}
	*/

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

	private function queryString($fields)
	{		
		$params = [];
		foreach ($fields as $afield)
		{
			$field = $afield[0];
			$tab = isset($afield[1])?$afield[1]:false;			
			if (!empty($this->$field))
			{				
				array_push($params,["like", "lower(".($tab?$tab.".":"").$field.")", strtolower($this->$field)]);
			}
		}	
		return $params;
	}	
	
	private function queryNumber($fields)
	{		
		$params = [];
		foreach ($fields as $afield)
		{
			$field = $afield[0];
			$tab = isset($afield[1])?$afield[1]:false;			
			if (!empty($this->$field))
			{				
				$number = explode(" ",trim($this->$field));							
				if (count($number) == 2)
				{									
					if (in_array($number[0],['>','>=','<','<=']) && is_numeric($number[1]))
					{
						array_push($params,[$number[0], ($tab?$tab.".":"").$field, $number[1]]);	
					}
				}
				elseif (count($number) == 3)
				{															
					if (is_numeric($number[0]) && is_numeric($number[2]))
					{
						array_push($params,['>=', ($tab?$tab.".":"").$field, $number[0]]);		
						array_push($params,['<=', ($tab?$tab.".":"").$field, $number[2]]);		
					}
				}
				elseif (count($number) == 1)
				{					
					if (is_numeric($number[0]))
					{
						array_push($params,['=', ($tab?$tab.".":"").$field, str_replace(["<",">","="],"",$number[0])]);		
					}	
				}
			}
		}	
		return $params;
	}
	
	private function queryTime($fields)
	{		
		$params = [];
		foreach ($fields as $afield)
		{
			$field = $afield[0];
			$tab = isset($afield[1])?$afield[1]:false;			
			if (!empty($this->$field))
			{				
				$time = explode(" - ",$this->$field);			
				if (count($time) > 1)
				{								
					array_push($params,[">=", "concat('',".($tab?$tab.".":"").$field.")", $time[0]]);	
					array_push($params,["<=", "concat('',".($tab?$tab.".":"").$field.")", $time[1]." 24:00:00"]);
				}
				else
				{
					if (substr($time[0],0,2) == "< " || substr($time[0],0,2) == "> " || substr($time[0],0,2) == "<=" || substr($time[0],0,2) == ">=") 
					{					
						array_push($params,[str_replace(" ","",substr($time[0],0,2)), "concat('',".($tab?$tab.".":"").$field.")", trim(substr($time[0],2))]);
					}
					else
					{					
						array_push($params,["like", "concat('',".($tab?$tab.".":"").$field.")", $time[0]]);
					}
				}	
			}
		}	
		return $params;
	}

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->find();
        
        <?php
			$joins = "";
			foreach ($relations as $tab)
			{
				if (!empty($tab))
				{
					$joins .= ($joins == ""?"":", ")."'".$tab."'";
				}
			}	
        ?>
        
        $query->joinWith([/*<?= $joins ?>*/]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        <?php
			echo "/* uncomment to sort by relations table on respective column"; 
			foreach ($relations as $tab)
			{
				if ($tab) {
				echo "
		\$dataProvider->sort->attributes['{$tab}Id'] = [			
			'asc' => ['{{%{$tab}}}.id' => SORT_ASC],
			'desc' => ['{{%{$tab}}}.id' => SORT_DESC],
		];";	
				}
				
			}
			echo "*/";         
        ?>


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }				
		
        <?= implode("\n        ", $searchConditions) ?>
		
		/* example to use search all in field1,field2,field3 or field4
		if ($this->search)
		{
			$query->andFilterWhere(["OR","lower(field1) like '%".strtolower($this->search)."%'",
				["OR","lower(field2) like '%".strtolower($this->search)."%'",
					["OR","lower(field3) like '%".strtolower($this->search)."%'",
						"lower(field4) like '%".strtolower($this->search)."%'"						
					]
				]
			]);	
		}	
		*/

        return $dataProvider;
    }
}
