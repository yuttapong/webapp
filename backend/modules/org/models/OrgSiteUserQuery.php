<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgSiteUser]].
 *
 * @see OrgSiteUser
 */
class OrgSiteUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgSiteUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgSiteUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
