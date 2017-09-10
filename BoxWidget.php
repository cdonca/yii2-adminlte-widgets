<?php

namespace wokster\ltewidgets;
use yii\bootstrap\Html;

/**
 * This is just an example.
 */
class BoxWidget extends \yii\base\Widget
{
    public $title;
    public $border = false;
    public $color = 'default';
    public $solid = false;
    public $padding = true;
    public $footer = false;
    public $collapse = true;
    public $hide = false;
    public $close = false;
    public $buttons = [];

    public function init()
    {
        parent::init();
        if($this->collapse)
            $this->buttons[] = ['button', '<i class="fa fa-minus"></i>', ['class'=>'btn btn-box-tool', 'data-widget'=>'collapse', 'data-toggle'=>'tooltip', 'data-original-title'=>'свернуть/развернуть']];
        if($this->close)
            $this->buttons[] = ['button', '<i class="fa fa-times"></i>', ['class'=>'btn btn-box-tool', 'data-widget'=>'remove', 'data-toggle'=>'tooltip', 'data-original-title'=>'скрыть']];
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        $html_data = Html::beginTag('div',['class'=>$this->boxClass(), 'data-widget'=>'box-widget']);
        $html_data .= Html::beginTag('div',['class'=>$this->boxHeaderClass()]);
        $html_data .= (!empty($this->title))?Html::tag('h3',$this->title,['class'=>'box-title']):'';
        $html_data .= Html::tag('div',$this->boxTools(),['class'=>'box-tools pull-right']);
        $html_data .= Html::endTag('div');
        $html_data .= Html::tag('div',$content,['class'=>'box-body']);
        $html_data .= ($this->footer)?Html::tag('div',$this->footer,['class'=>'box-footer']):'';
        $html_data .= Html::endTag('div');
        return $html_data;
    }

    private function boxClass(){
        $class = 'box box-'.$this->color;
        if($this->solid)
            $class .= ' box-solid';
        if($this->hide)
            $class .= ' collapsed-box';
        return $class;
    }
    private function boxHeaderClass(){
        $class = 'box-header';
        if($this->border)
            $class .= ' with-border';
        return $class;
    }
    private function boxTools(){
        $html = '';
        if(is_array($this->buttons)){
            foreach ($this->buttons as $btn){
                if($btn[0] == 'button'){
                    $html .= Html::button($btn[1],array_merge(['class'=>'btn btn-box-tool'],$btn[2]));
                }else{
                    $html .= Html::a($btn[1],$btn[2],array_merge(['class'=>'btn btn-box-tool'],$btn[3]));
                }
            }
        }
        return $html;
    }
}
