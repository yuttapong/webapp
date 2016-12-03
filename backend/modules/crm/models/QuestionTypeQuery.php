<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[QuestionType]].
 *
 * @see QuestionType
 */
class QuestionTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return QuestionType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return QuestionType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
