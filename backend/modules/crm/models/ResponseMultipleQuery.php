<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[ResponseMultiple]].
 *
 * @see ResponseMultiple
 */
class ResponseMultipleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ResponseMultiple[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ResponseMultiple|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
