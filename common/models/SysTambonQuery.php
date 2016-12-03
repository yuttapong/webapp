<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SysTambon]].
 *
 * @see SysTambon
 */
class SysTambonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SysTambon[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SysTambon|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
