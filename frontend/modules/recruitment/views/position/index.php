<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ตำแหน่งงานที่เปิดรับสม้คร';
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(); ?>
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'position.name_th',
            [
                'attribute' =>  'position.name_th',
                'value' => function($model){
                    return Html::a($model->position->name_th,['view','id'=>$model->id]);
                },
                'format' => 'raw',
            ],
            'qty',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>[
                    'noWrap' => true
                ],
                'buttons' => [
                    'apply' => function($url,$model){
                        return Html::a('สมัครงาน',['resume/apply','id'=>$model->id]);
                    }

                ],
                'template' => "{view} {apply}",
            ],
        ],
    ]);
?>
<?php Pjax::end(); ?>

