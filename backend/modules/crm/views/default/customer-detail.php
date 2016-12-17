<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 17/12/2559
 * Time: 14:47
 */
use yii\helpers\Html;
?>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
<?php
        if ($model->prefixname) {
            echo Html::tag('div', Html::activeLabel($model, 'prefixname') . ': ' . Html::tag('span', $model->prefixname));
        }
        ?>
<?php
if ($model->prefixname_other) {
    echo Html::tag('div', Html::activeLabel($model, 'prefixname_other') . ': ' . Html::tag('span', $model->prefixname_other));
}
?>

<?php
if ($model->firstname) {
    echo Html::tag('div', Html::activeLabel($model, 'firstname') . ': ' . Html::tag('span', $model->firstname . ' ' . $model->lastname));
}
?>
<?php
if ($model->gender) {
    echo Html::tag('div', Html::activeLabel($model, 'gender') . ': ' . Html::tag('span', $model->genderName));
}
?>

<?php
if ($model->birthday) {
    echo Html::tag('div', Html::activeLabel($model, 'birthday') . ': ' . Html::tag('span', $model->birthday));
}
?>

<?php
if ($model->mobile) {
    echo Html::tag('div', Html::activeLabel($model, 'mobile') . ': ' . Html::tag('span', $model->mobile));
}
?>
<?php
if ($model->tel) {
    echo Html::tag('div', Html::activeLabel($model, 'tel') . ': ' . Html::tag('span', $model->tel));
}
?>
<?php
if ($model->age) {
    echo Html::tag('div', Html::activeLabel($model, 'age') . ': ' . Html::tag('span', $model->age));
}
?>
<?php
if ($model->email) {
    echo Html::tag('div', Html::activeLabel($model, 'email') . ': ' . Html::tag('span', $model->email));
}
?>
<?php
if ($model->is_vip) {
    echo Html::tag('div', Html::activeLabel($model, 'is_vip') . ': ' . Html::tag('span', $model->is_vip));
}
?>
<?php
if ($model->source) {
    echo Html::tag('div', Html::activeLabel($model, 'source') . ': ' . Html::tag('span', $model->sourceName));
}
?>
<?php
// if ($model->currentPersonInCharge) {
echo Html::tag('div', Html::activeLabel($model, 'currentPersonInCharge') . ': ' . Html::tag('span', $model->currentPersonInChargeFullname));
// }
?>
<?php
if ($model->created_by) {

    $timeCreated = \common\siricenter\thaiformatter\ThaiDate::widget([
        'timestamp' => $model->created_at,
        'showTime' => true,
    ]);

    echo html::tag('div', Html::activeLabel($model, 'created_by') . ': ' . Html::tag('span', $model->createdName . " ({$timeCreated})"));
}
?>


<?php
if ($model->updated_by) {
    $timeUpdated = Html::tag('span', \common\siricenter\thaiformatter\ThaiDate::widget([
        'timestamp' => $model->updated_at,
        'showTime' => true,
    ]));
    echo Html::tag('div', Html::activeLabel($model, 'updated_by') . ': ' . $model->updatedName . " ({$timeUpdated})");
}
?>

</div>


    <div class="col-xs-12 ">
        <div style="text-align:left;">
            <?php
            if (Yii::$app->user->can('/crm/customer/view')) :
                echo Html::a('<i class="fa fa-search"></i> รายละเอียดเพิ่ม....',
                    ['customer/view', 'id' => $model->id],
                    [
                        'class' => 'btn btn-sm btn-default',
                        'title' => 'รายละเอียดเพิ่มเติม',
                        'target' => '_blank'
                    ]);
            endif;
            ?>
            <?php
            if (Yii::$app->user->can('/crm/customer/choose-survey')) :
                echo Html::a('<i class="fa fa-plus"></i> คลิกที่่นี่ ! เพื่อเพิ่มแบบสอบถามใหม่',
                    ['customer/choose-survey', 'customerId' => $model->id],
                    [
                        'class' => 'btn btn-sm btn-success',
                        'title' => 'เพิ่มแบบสอบถาม - New Questionnaire',
                        'target' => '_blank'
                    ]);
            endif;
            ?>



        </div>

</div>