<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[ResponseOther]].
 *
 * @see ResponseOther
 */
class ResponseOtherQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ResponseOther[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ResponseOther|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
