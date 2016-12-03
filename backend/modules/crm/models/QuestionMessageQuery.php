<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[QuestionMessage]].
 *
 * @see QuestionMessage
 */
class QuestionMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return QuestionMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return QuestionMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
