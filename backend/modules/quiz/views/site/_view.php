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
        echo $model->title;
    ?>
    <br/>
    <?php
        echo Html::radioList($model->id, $model->user_answer, $model->answers, array('class' => 'question'));
    ?>
</div>