<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use \wokster\ltewidgets\BoxWidget;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Создать ' . $generator->title_vin) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($generator->title_all) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">

    <?= "<?php " ?>BoxWidget::begin([
    'title'=>'<?=$generator->title_im?>: форма добавления',
    ]);
    <?= "?>\n\n" ?>
    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= "<?php " ?>BoxWidget::end();<?= "?>\n" ?>

</div>
