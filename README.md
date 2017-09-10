Adminlte widgets and helpers for yii2
=====================================
Adminlte widgets, helpers and gii for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist wokster/yii2-adminlte-widgets "*"
```

or add

```
"wokster/yii2-adminlte-widgets": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Use BoxWidget to add your content in adminLTE box
full config:
```php
    <?php BoxWidget::begin([
        'title' => 'Some title', //string
        'border' => false,       //boolean
        'color' => 'default',    //bootstrap color name 'success', 'danger' еtс.
        'solid' => false,        //boolean
        'padding' => true,       //boolean
        'footer' => false,       //boolean or html to render footer
        'collapse' => true,      //boolean Default AdminLTE button for collapse box
        'close' => false,        //boolean Default AdminLTE button for remove box
        'hide' => false,         //boolean collapsed or not
        'buttons' => [           //array with config to add custom buttons or links
              //sample for links, like in default gii view template
              ['link', '<i class="fa fa-times text-danger" aria-hidden="true"></i>',['delete', 'id' => $model->id],[
                'data-toggle'=>'tooltip', 'data-original-title'=>'delete it',
                'data' => [
                'confirm' => 'Вы уверены, что хотите безвозвратно удалить партнера?',
                'method' => 'post',
              ],]],
              ['link', '<i class="fa fa-pencil" aria-hidden="true"></i>',['update','id' => $model->id],['data-toggle'=>'tooltip', 'data-original-title'=>'update it']],
              //sample for custom button
              ['button', '<i class="fa fa-cog"></i>', ['class'=>'btn btn-box-tool', 'data-toggle'=>'tooltip', 'data-original-title'=>'some tooltip']]
        ],
    ]);
    ?>

    <?php echo 'some content'; ?>

    <?php BoxWidget::end();?>
```


To use gii with adminLTE template, add in config:
```php
    'modules' => [
    ....
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
            'generators' => [
                'tcrud'   => [
                    'class'     => '\wokster\ltewidgets\generators\tcrud\Generator',
                ],
                'tmodel'   => [
                    'class'     => '\wokster\ltewidgets\generators\tmodel\Generator',
                ]
            ]
        ],
    ....
    ],
```
this generator can create widgets for upload files and add behaviors and rules etc. in model and form. It's based on column names. So try name your column as:<br />
text - gen imperavi redactor widget in form<br />
status_id - gen status behavior in model and dropdown in form<br />
url - gen autogenerate js from "title" attribute<br />
img or image or media_url - gen behavior for upload in model and widget in form<br />
date or date_start or date_finish - datePicker in form<br />
sort - add rules for integer 1 - 99