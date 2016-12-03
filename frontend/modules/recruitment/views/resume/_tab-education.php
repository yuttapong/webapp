<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 10/6/2559
 * Time: 10:05
 */

$modelEducation = new \backend\modules\org\models\OrgPersonnelEducation();
?>

<table class="table table-striped table-bordered">
    <tr>
        <th><?= Html::activeLabel($modelEducation, 'sorter'); ?></th>
        <th><?=Html::activeLabel($modelEducation,'end_year')?></th>
        <th><?= Html::activeLabel($modelEducation, 'education_name'); ?></th>
        <th><?= Html::activeLabel($modelEducation, 'branch'); ?></th>
        <th><?= Html::activeLabel($modelEducation, 'grade'); ?></th>

    </tr>
<?php
if($model->educations){
    foreach ($model->educations as $e){
        ?>
        <tr>
            <td><?=$e->sorter?></td>
            <td><?=$e->end_year?></td>
            <td><?=$e->education_name?></td>
            <td><?=$e->branch?></td>
            <td><?=$e->grade?></td>

        </tr>
 <?php
    }
}

?>
</table>
