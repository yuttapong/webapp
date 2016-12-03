<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[QuestionChoice]].
 *
 * @see QuestionChoice
 */
class QuestionChoiceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return QuestionChoice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return QuestionChoice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
