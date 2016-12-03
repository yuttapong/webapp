<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[RcmAppJobOption]].
 *
 * @see RcmAppJobOption
 */
class OrgJobOptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RcmAppJobOption[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RcmAppJobOption|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
