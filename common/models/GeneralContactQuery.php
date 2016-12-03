<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GeneralContact]].
 *
 * @see GeneralContact
 */
class GeneralContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GeneralContact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GeneralContact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
