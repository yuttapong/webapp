<?php
use yii\bootstrap\Html;

$this->title = 'Dashboard';
echo Html::beginTag('div', ['class' => 'row']);
foreach ($items as $name => $item) {
    echo Html::beginTag('div', ['class' => 'col-xs-4 col-sm-3']);
    echo Html::beginTag('div', ['class' => 'alert alert-warning']);
    echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-xs-12 col-sm-12']);
    echo Html::tag('div', "<i class='{$item['icon']} fa-3x'></i>", ['align' => 'center']);
    echo Html::endTag('div');
    echo Html::beginTag('div', ['class' => 'col-xs-12 col-sm-12', 'align' => "center"]);
    $link = Html::a($item['name'], $item['url']);
    echo Html::tag('div', $link . ' <span class="badge badge-red">' . $item['count'] . '</span>', ['class' => '']);

    echo Html::endTag('div');
    echo Html::endTag('div');
    echo Html::endTag('div');
    echo Html::endTag('div');

}
echo Html::endTag('div');

 \kartik\sortable\Sortable::widget([
    'type' => 'grid',
    'items' => [
        ['content' => '<div class="grid-item text-danger">Item 1</div>'],
        ['content' => '<div class="grid-item text-danger">Item 2</div>'],
        ['content' => '<div class="grid-item text-danger">Item 3</div>'],
        ['content' => '<div class="grid-item text-danger">Item 4</div>'],
        ['content' => '<div class="grid-item text-danger">Item 5</div>'],
        ['content' => '<div class="grid-item text-danger">Item 6</div>'],
        ['content' => '<div class="grid-item text-danger">Item 7</div>'],
        ['content' => '<div class="grid-item text-danger">Item 8</div>'],
        ['content' => '<div class="grid-item text-danger">Item 9</div>'],
        ['content' => '<div class="grid-item text-danger">Item 10</div>'],
    ],
    'pluginEvents' => [
        'sortupdate' => '',
    ]
]);



