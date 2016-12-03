<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgCompany]].
 *
 * @see OrgCompany
 */
class OrgCompanyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgCompany[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgCompany|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
