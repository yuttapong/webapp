<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Bemployee]].
 *
 * @see Bemployee
 */
class BemployeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Bemployee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Bemployee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
