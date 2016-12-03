<?php

namespace backend\modules\recruitment\models;

/**
 * This is the ActiveQuery class for [[RcmAppProperty]].
 *
 * @see RcmAppProperty
 */
class RcmAppPropertyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RcmAppProperty[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RcmAppProperty|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
