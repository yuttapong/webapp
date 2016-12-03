<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SysModule]].
 *
 * @see SysModule
 */
class SysModuleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SysModule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SysModule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
