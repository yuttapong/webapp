<?php

namespace frontend\modules\recruitment\models;

/**
 * This is the ActiveQuery class for [[RcmAppForm]].
 *
 * @see RcmAppForm
 */
class ResumeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
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
