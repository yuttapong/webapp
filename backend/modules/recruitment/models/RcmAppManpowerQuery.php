<?php

namespace backend\modules\recruitment\models;

/**
 * This is the ActiveQuery class for [[RcmAppManpower]].
 *
 * @see RcmAppManpower
 */
class RcmAppManpowerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RcmAppManpower[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RcmAppManpower|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
