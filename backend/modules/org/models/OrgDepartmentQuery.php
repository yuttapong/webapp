<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgDepartment]].
 *
 * @see OrgDepartment
 */
class OrgDepartmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgDepartment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgDepartment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
