<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SysProvince]].
 *
 * @see SysProvince
 */
class SysProvinceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SysProvince[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SysProvince|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
