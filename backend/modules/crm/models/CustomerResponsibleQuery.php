<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[CustomerResponsible]].
 *
 * @see CustomerResponsible
 */
class CustomerResponsibleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CustomerResponsible[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CustomerResponsible|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
