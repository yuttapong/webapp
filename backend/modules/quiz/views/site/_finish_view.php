<?php
/**
 * Yii quiz
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.oligalma.com
 * @copyright 2016 Oligalma
 * @license GPL License
 */

use yii\helpers\Html; 
 ?>
<div class="quiz-answer">
    <?php       
        echo $model->title . '&nbsp;&nbsp;';
        if($model->user_answer === $model->answer)
            echo Html::img(Yii::$app->controller->module->assetsUrl . '/images/ok.png', array('style' => 'vertical-align:middle;'));
        else 
            echo Html::img(Yii::$app->controller->module->assetsUrl . '/images/wrong.png', array('style' => 'vertical-align:middle;'));
    ?>
    <br/>
    <span>
        <?php
            foreach($model->answers as $key => $value):
        ?>
            <?php
                if($model->answer == $key):
            ?>
                <b><?= $value ?></b>
            <?php
                elseif($model->answer != $key && $model->user_answer == $key):
            ?>
                <del><?= $value ?></del>
            <?php
                else:
            ?>
                <?= $value ?>
            <?php
                endif;
            ?>
            <br/>
        <?php
            endforeach;
        ?>
    </span>
</div>