<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use \wokster\ltewidgets\BoxWidget;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($generator->title_all) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <?= "<?php " ?>BoxWidget::begin([
    'title'=>'<?=$generator->title_im?>: просмотр',
    'buttons' => [
      ['link', '<i class="fa fa-times text-danger" aria-hidden="true"></i>',['delete', <?= $urlParams ?>],[
        'data-toggle'=>'tooltip', 'data-original-title'=>'удалить',
        'data' => [
        'confirm' => <?= $generator->generateString('Вы уверены, что хотите безвозвратно удалить '.$generator->title_vin.'?') ?>,
        'method' => 'post',
      ],]],
      ['link', '<i class="fa fa-pencil" aria-hidden="true"></i>',['update',<?= $urlParams ?>],['data-toggle'=>'tooltip', 'data-original-title'=>'редактировать']],
    ]
    ]);
    <?= "?>\n\n" ?>
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
foreach ($generator->getColumnNames() as $name) {
          echo "\t\t\t\t\t'" . $name . "',\n";
}
} else {
foreach ($generator->getTableSchema()->columns as $column) {
$format = $generator->generateColumnFormat($column);
switch ($column->name) {
case 'status_id':
        echo "\t\t\t\t\t'status',\n";
break;
case 'img':
        echo "\t\t\t\t\t[\n";
        echo "\t\t\t\t\t\t'attribute' => 'img',\n";
        echo "\t\t\t\t\t\t'format' => 'raw',\n";
        echo "\t\t\t\t\t\t'value' => Html::img(\$model->smallImage, ['width'=>'50']),\n";
        echo "\t\t\t\t\t],\n";
break;
case 'text':
        echo "\t\t\t\t\t'text:raw',\n";
break;
case 'date':
case 'start_date':
case 'finish_date':
        echo "\t\t\t\t\t'".$column->name.":date',\n";
break;
default:
        echo "\t\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
}
}
}
?>
        ],
    ]) ?>
    <?= "<?php " ?>BoxWidget::end();<?= "?>" ?>
</div>
