<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SysAmphur]].
 *
 * @see SysAmphur
 */
class SysAmphurQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SysAmphur[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SysAmphur|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
