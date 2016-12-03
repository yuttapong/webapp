<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[ResponseText]].
 *
 * @see ResponseText
 */
class ResponseTextQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ResponseText[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ResponseText|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
