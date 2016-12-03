<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgSite]].
 *
 * @see OrgSite
 */
class OrgSiteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgSite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgSite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
