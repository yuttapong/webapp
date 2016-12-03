<?php
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;

 ?>
<?php $this->beginContent('@backend/views/layouts/main-full.php'); ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-centent">
            <?php
            echo Nav::widget([
                'items' => [
                    [
                        'label' => 'โปร์ไฟล์',
                        'url' => ['profile/index'],
                    ],
                    [
                        'label' => 'เปลี่ยนรหัสผ่าน',
                        'url' => ['profile/update'],
                    ]
                ],
                'options' => ['class' =>'nav nav-tabs'], // set this to nav-tab to get tab-styled navigation
            ]);
            ?>
            <p>
                <?php echo $content; ?>
            </p>

        </div>

    </div>

</div>


<?php $this->endContent(); ?>
