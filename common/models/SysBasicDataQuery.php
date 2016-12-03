<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SysBasicData]].
 *
 * @see SysBasicData
 */
class SysBasicDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SysBasicData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SysBasicData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
