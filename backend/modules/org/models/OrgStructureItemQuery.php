<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgStructureItem]].
 *
 * @see OrgStructureItem
 */
class OrgStructureItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgStructureItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgStructureItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
