<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgBenefits]].
 *
 * @see OrgBenefits
 */
class OrgBenefitsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgBenefits[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgBenefits|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}