<?php
/**
 * Yii quiz
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.oligalma.com
 * @copyright 2016 Oligalma
 * @license GPL License
 */

namespace app\modules\quiz\models;
 
class QuizUserAnswer
{
    public $id;
    public $question_id;
    public $user_answer;
    public $title;
    public $answer;
    public $answers;
}