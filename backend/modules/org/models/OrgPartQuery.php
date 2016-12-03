<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgPart]].
 *
 * @see OrgPart
 */
class OrgPartQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgPart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgPart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
