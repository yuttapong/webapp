<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[ResponseBoolean]].
 *
 * @see ResponseBoolean
 */
class ResponseBoolean extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ResponseBoolean[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ResponseBoolean|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
