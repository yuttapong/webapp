<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
use backend\modules\recruitment\RequestAsset;



/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnel */

$this->title = $modelPersonnel->fullnameTH;
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = ['label' => 'ใบสมัครงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-personnel-view">
    <p>
        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ลบ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('recruitment','เรียกสัมภาษณ์'), ['interview/create', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => Yii::t('recruitment','ต้องการเรียกสัมภาษณ์ '.$model->code.' : '.$model->personnel->fullnameTH).' ?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::button('สร้างรหัสผ่านเข้าสู่ระบบ', [
             'class' => 'btn btn-info btn-resume-generate-pwd',
             'data-resume' => $model->id,
        ]) ?>
    </p>
    <div class="row">
        <div class="col-xs-3 col-sm-4 col-md-2">
            <?php echo Html::img($model->photoUrl,['class' => 'img img-responsive img-thumbnail'])?>
            <?=Html::tag('div',Html::activeLabel($model,'pwd').' : <span id="resume-key" class="text-default">'.$model->pwd.'</span>',['class'=>'text-strong'])?>
        </div>
        <div class="col-xs-9 col-sm-8 col-md-10">
            <table class="table">
                <tr>
                    <td><?=Html::activeLabel($model,'code')?></td>
                    <td><?=Html::decode($model->code)?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($modelPersonnel,'fullnameTH')?></td>
                    <td><?=Html::decode($modelPersonnel->fullnameTH)?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($modelPersonnel,'educations')?></td>
                    <td><?=$modelPersonnel->getLatestEductionName()?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($modelPersonnel,'age')?></td>
                    <td><?=$modelPersonnel->age?>  ปี</td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($modelPersonnel,'birthday')?></td>
                    <td>
                        <?php echo Yii::$app->formatter->asDate($modelPersonnel->birthday)?>
                    </td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'positionApply')?></td>
                    <td>
                        <?=$model->showApplyPosition?>
                    </td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'salary_desired')?></td>
                    <td><?=$model->salary_desired?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'created_at')?></td>
                    <td><?=Yii::$app->formatter->asDatetime($model->created_at)?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'updated_at')?></td>
                    <td><?=Yii::$app->formatter->asDatetime($model->updated_at)?></td>
                </tr>
            </table>

            
        </div>
    </div>
<br>
    <?php
    $items = [
        [
            'label' => '<i class="fa fa-user"></i> ทั่วไป',
            'content' => $this->render('_tab-general', [
                'model' => $modelPersonnel
            ]),
            'active' => true
        ],
        [
            'label' => '<i class="fa fa-graduation-cap" aria-hidden="true"></i> การศึกษา',
            'content' => $this->render('_tab-education', [
                'model' => $modelPersonnel
            ]),
        ],
        [
            'label' => '<i class="fa fa-graduation-group" aria-hidden="true"></i> ประวัติการทำงาน',
            'content' => $this->render('_tab-work', [
                'model' => $modelPersonnel
            ]),
        ],
    ];
?>

    <?php

    echo TabsX::widget([
        'items' => $items,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
        //'bordered' => true,
    ]);
    ?>
</div>
<?php
$this->registerJs("
    $(\".btn-resume-generate-pwd\").on('click',function () {
        if (confirm('ต้องการสร้างรหัสผ่านสำหรับการการทำแบบทดสอบใช่หรือไม่ ?')) {
           var code = $(this).data('code');
           var  resume = $(this).data('resume');
           $.ajax({
             'type':'post',
             'url': 'generate-pwd',
             'data':{id:resume,code:code},
             'dataType':'json',
             'success':function(rs){
                $('#resume-key').html(rs.key);
              }
            });
        }
    })

");
?>