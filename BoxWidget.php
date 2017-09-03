<?php

namespace wokster\ltewidgets;
use yii\bootstrap\Html;

/**
 * This is just an example.
 */
class BoxWidget extends \yii\base\Widget
{
    public $content;
    public $title;
    public $border = false;
    public $color = 'default';
    public $solid = false;
    public $padding = true;
    public $footer = false;
    public $buttons = [
        ['button', '<i class="fa fa-minus"></i>', ['class'=>'btn btn-box-tool', 'data-widget'=>'collapse']],
        /*['button', '<i class="fa fa-times"></i>', ['class'=>'btn btn-box-tool', 'data-widget'=>'remove']],*/
    ];

    public function run()
    {
        echo Html::beginTag('div',['class'=>$this->boxClass(), 'data-widget'=>'box-widget']);
            echo Html::beginTag('div',['class'=>$this->boxHeaderClass()]);
                echo (!empty($this->title))?Html::tag('h3',$this->title,['class'=>'box-title']):'';
                echo Html::tag('div',$this->boxTools(),['class'=>'box-tools pull-right']);
            echo Html::endTag('div');
            echo Html::tag('div',$this->content,['class'=>'box-body']);
            echo ($this->footer)?Html::tag('div',$this->footer,['class'=>'box-footer']):'';
        echo Html::endTag('div');
    }

    private function boxClass(){
        $class = 'box box-'.$this->color;
        if($this->solid)
            $class = ' box-solid';
        return $class;
    }
    private function boxHeaderClass(){
        $class = 'box-header';
        if($this->border)
            $class = ' with-border';
        return $class;
    }
    private function boxTools(){
        $html = '';
        if(is_array($this->buttons)){
            foreach ($this->buttons as $btn){
                if($btn[0] == 'button'){
                    $html .= Html::button($btn[1],$btn[2]);
                }else{
                    $html .= Html::a($btn[1],$btn[2],$btn[3]);
                }
            }
        }
        return $html;
    }
}
