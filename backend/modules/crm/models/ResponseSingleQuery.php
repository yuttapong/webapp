<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[ResponseSingle]].
 *
 * @see ResponseSingle
 */
class ResponseSingleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ResponseSingle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ResponseSingle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
