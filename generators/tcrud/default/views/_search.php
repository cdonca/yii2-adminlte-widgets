<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<?= "<?php " ?>BoxWidget::begin([
        'title'=>'расширенный поиск',
        'hide'=>true,
]);
<?= "?>" ?>

    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<?php
$count = 0;

foreach ($generator->getColumnNames() as $attribute) {
    echo '<div class="col-xs-3">';

    if($attribute == 'status') {
        echo "    <?= ";
        ?>
        $form->field($model, 'status')->dropDownList($model->getStatusList(),['prompt'=>''])
    <?php
        echo " ?>\n\n";
    }else{
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }

    echo '</div>';
}

?>
    <div class="form-group col-xs-12">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

<?= "<?php " ?>BoxWidget::end();<?= "?>" ?>
