<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator common\components\generators\tcrud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

if($model->hasErrors()):
\wokster\ltewidgets\BoxWidget::begin([
'solid'=>true,
'color'=>'danger',
'title'=>'Ошибки валидации',
'close'=> true,
]);
$error_data = $model->firstErrors;
echo \yii\widgets\DetailView::widget([
'model'=>$error_data,
'attributes'=>array_keys($error_data)
]);
\wokster\ltewidgets\BoxWidget::end();
endif;

?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
<?php if (in_array('img',$generator->getColumnNames())): ?>
        'options' => ['enctype'=>'multipart/form-data'],
<?php endif; ?>
    ]); ?>
<?php foreach ($generator->getColumnNames() as $attribute) {
if (in_array($attribute, $safeAttributes)) {
switch ($attribute){
case 'status_id':?>
            <?php echo "<?="; ?> $form->field($model, 'status_id',['options'=>['class'=>'col-xs-12 col-md-6']])->dropDownList($model->getStatusList())
            <?php echo " ?>\n\n"; ?>
<?php
break;
case 'url':?>
            <?php echo "<?="; ?> $form->field($model, 'url', ['addon' => ['prepend' => ['content' => '<i class="fa fa-globe"></i>']],'options'=>['class'=>'col-xs-12 col-md-6']])
            <?php echo " ?>\n\n"; ?>
<?php
break;
case 'text':?>
            <?php echo "<?="; ?> $form->field($model, 'text',['options'=>['class'=>'col-xs-12']])->widget(\vova07\imperavi\Widget::className(),[
                    'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'pastePlainText' => true,
                    'imageUpload' => \yii\helpers\Url::to(['/main/image/save-redactor-img','id'=>null,'sub'=>'<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>']),
                    'replaceDivs' => false,
                    'plugins' => [
                    'fullscreen',
                    'table'
                    ]
                    ]
                    ])
            <?php echo " ?>\n\n"; ?>
<?php
break;
case 'img':
case 'image':
case 'media_url':
                    ?>
            <?php echo "<?="; ?> $form->field($model, 'file',['options'=>['class'=>'col-xs-12 col-md-6']])->label('Картинка',['style'=>'float:none; display:block;'])->widget(\dosamigos\fileinput\FileInput::className(),
                [
                    'attribute' => '<?=$attribute?>',
                    'style'=>\dosamigos\fileinput\FileInput::STYLE_IMAGE,
                    'thumbnail'=>'<img src="'.$model->getImage().'" style="width:100%;">',
                ])
            <?php echo " ?>\n\n"; ?>
<?php
break;
case 'date':
case 'date_start':
case 'date_finish':?>
            <?php echo "<?="; ?> $form->field($model, '<?=$attribute?>', ['addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],'options'=>['class'=>'col-xs-12 col-md-6']])->widget(\kartik\datecontrol\DateControl::className(),[
                    'type'=>'date',
                    ])
            <?php echo " ?>\n\n"; ?>
<?php
break;
case 'sort':?>
            <?php echo "<?="; ?> $form->field($model, '<?=$attribute?>',['options'=>['class'=>'col-xs-12 col-md-6']])->textInput()<?php echo " ?>\n\n"; ?>
<?php
break;
default:?>
            <?php echo "<?="; ?> $form->field($model, '<?=$attribute?>',['options'=>['class'=>'col-xs-12']])->textInput()<?php echo " ?>\n\n"; ?>
<?php
            }
        }
    } ?>

        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Добавить') ?> : <?= $generator->generateString('Сохранить') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>
