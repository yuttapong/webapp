<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgPersonnel]].
 *
 * @see OrgPersonnel
 */
class OrgPersonnelQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgPersonnel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgPersonnel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
