<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgReasonForLeaving]].
 *
 * @see OrgReasonForLeaving
 */
class OrgReasonForLeavingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgReasonForLeaving[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgReasonForLeaving|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
