<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgDivision]].
 *
 * @see OrgDivision
 */
class OrgDivisionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgDivision[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgDivision|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
