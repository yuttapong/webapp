<?php

namespace backend\modules\recruitment\models;

/**
 * This is the ActiveQuery class for [[RcmAppForm]].
 *
 * @see RcmAppForm
 */
class RcmAppFormQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return RcmAppForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RcmAppForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}