<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[TreeManager]].
 *
 * @see TreeManager
 */
class TreeManagerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TreeManager[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TreeManager|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
