<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[Communication]].
 *
 * @see Communication
 */
class CommunicationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Communication[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Communication|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
