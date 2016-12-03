<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgPosition]].
 *
 * @see OrgPosition
 */
class OrgPositionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgPosition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgPosition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
