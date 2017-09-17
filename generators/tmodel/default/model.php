<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
$image = false;
$sort = false;
if(count(array_intersect(['img','image','media_url'],$tableSchema->columnNames)) > 0)
{
  $rules[] = "[['file'], 'file', 'maxSize' => 2097152]";
  $image = true;
}
if(in_array('sort',$tableSchema->columnNames))
{
  $rules[] = "[['sort'], 'number', 'min'=>'1', 'max'=>'99' ]";
  $sort = true;
}
if(in_array('email',$tableSchema->columnNames))
{
  $rules[] = "[['email'], 'email']";
}
if(in_array('url',$tableSchema->columnNames))
{
  $rules[] = "[['url'], 'match', 'pattern' => '/^[a-z0-9_-]+$/', 'message' => 'Недопустимые символы в url']";
}
echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

/**
* This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
*
<?php foreach ($tableSchema->columns as $column): ?>
  * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
  *
  <?php foreach ($relations as $name => $relation): ?>
    * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
  <?php endforeach; ?>
<?php endif; ?>
*/
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{

<?php if($image):?>
  public $file;

  const IMAGE_DIR_NAME = '<?= \yii\helpers\Inflector::camel2id(\yii\helpers\StringHelper::basename($generator->modelClass)) ?>';
<?php endif;?>

  /**
  * @inheritdoc
  */
  public static function tableName()
  {
    return '<?= $generator->generateTableName($tableName) ?>';
  }

  /**
  * @inheritdoc
  */
  public function behaviors()
  {
    return [
<?php if(in_array('status_id',$tableSchema->columnNames)):
$rules[] = "[['status_id'], 'default', 'value'=>0]"; ?>
            'status' => [
              'class' => \wokster\behaviors\StatusBehavior::className(),
              'status_value' => $this->status_id,
              'statusList' => [1=>'on', 0=>'off'],
            ],
<?php endif; ?>
<?php if($image):?>
            'image_uploader' => [
              'class' => \wokster\behaviors\ImageUploadBehavior::className(),
              'size_for_resize' => [
              [400,400,true],
              [1000,null,false],
              [50,50,true]
              ],
              'dir_name'=>self::IMAGE_DIR_NAME,
<?php if(in_array('image',$tableSchema->columnNames)):?>
              'attribute' => 'image',
<?php endif;?>
<?php if(in_array('media_url',$tableSchema->columnNames)):?>
              'attribute' => 'media_url',
<?php endif;?>
            ],
<?php endif;?>
          ];
  }
<?php if ($generator->db !== 'db'): ?>

  /**
  * @return \yii\db\Connection the database connection used by this AR class.
  */
  public static function getDb()
  {
    return Yii::$app->get('<?= $generator->db ?>');
  }
<?php endif; ?>

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
<?php foreach ($labels as $name => $label): ?>
        <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
<?php if(in_array('status_id',$tableSchema->columnNames)): ?>
        'Status' => 'статус',
<?php endif; ?>
    ];
  }
<?php foreach ($relations as $name => $relation): ?>

  /**
  * @return \yii\db\ActiveQuery
  */
  public function get<?= $name ?>()
  {
  <?= $relation[0] . "\n" ?>
  }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
  <?php
  $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
  echo "\n";
  ?>
  /**
  * @inheritdoc
  * @return <?= $queryClassFullName ?> the active query used by this AR class.
  */
  public static function find()
  {
  return new <?= $queryClassFullName ?>(get_called_class());
  }
<?php endif; ?>
}
