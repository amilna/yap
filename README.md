YAP
===
Yii2 Add-ons & Plugins

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist amilna/yii2-yap "*"
```

or add

```
"amilna/yii2-yap": "*"
```

to the require section of your `composer.json` file.

Available widgets:
1. GridView, a grid view that groups rows by any column(s). Combination of [2amigos/GroupGridView](https://github.com/2amigos/yii2-grid-view-library/blob/master/GroupGridView.php) and [kartik-v/yii2-grid](https://github.com/kartik-v/yii2-grid)
2. SequenceJs, a widget to renders a [Sequence JS](http://sequencejs.com). More information see [amilna/yii2-sequence-widget](https://github.com/amilna/yii2-sequence-widget)


Also include alternative gii template. To use it, add following line to your config (main-local.php):


```
$config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'amilna\yap\gii\crud\Generator',
                'templates' => [
                'default' => '@yii/gii/generators/crud/default',
                'amilna' => '@amilna/yap/gii/crud/default'
                ]
            ],
            'model' => [
                'class' => 'amilna\yap\gii\model\Generator',
                'templates' => [
                'default' => '@yii/gii/generators/model/default',
                'amilna' => '@amilna/yap/gii/model/default'
                ]
            ],
        ]
    ];

```