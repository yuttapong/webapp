<?php
namespace common\libs\tree_ajax;
use yii;
use yii\base\Widget;
use yii\web\View;
use yii\web\JqueryAsset;
use yii\bootstrap\Html;


class TreeAjax extends Widget
{
  public $root;
  public $mainTemplate = <<< HTML
<div class="row">
    <div class="col-sm-3">
        {wrapper}
    </div>
    <div class="col-sm-9">
        {detail}
    </div>
</div>
HTML;
  public $wrapperTemplate = "{header}\n{tree}{footer}";
  public $headerTemplate = <<< HTML
<div class="row">
    <div class="col-sm-6">
        {heading}
    </div>
    <div class="col-sm-6">
        {search}
    </div>
</div>
HTML;
  public function init() {
	
  }
  public function run() {
  		TreeAjaxAsset::register($this->getView());
 //  return    $this->renderWidget();
  }
  public function renderWidget()
  {
  	$content = strtr($this->mainTemplate, [
  		   '{wrapper}' => $this->renderWrapper(),
            '{detail}' =>'detail',
  	]);
  	return strtr($content, [
  			'{heading}' => 'heading',
  			'{search}' => 'search',
  		
  	]);
  
  }
  public function renderWrapper()
  {
  	$content = strtr($this->wrapperTemplate, [
  			'{header}' =>$this->renderHeader(),
  			'{tree}' =>$this->renderTree(),
  			'{footer}' => $this->renderToolbar(),
  	]);
  	return Html::tag('div', $content,  ['class' => 'kv-tree-wrapper form-control'] );
  }
  public function renderHeader()
  {
  	return Html::tag('div', $this->headerTemplate, ['class'=>'kv-header-container']);
  }
  public function renderToolbar()
  {
  	$out = "footer  \n";
  	return $out;
  }
  public function renderTree(){
  	$out = Html::beginTag('ul', ['class' => 'kv-tree']) . "\n";
  	$out .='<div class="kv-tree-root">ddddddddd
  				</div>';
  	return Html::tag('div',  $out, ['style' => 'height:410px']);
  }
  
}