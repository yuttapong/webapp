<?php

namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[OrgPersonnelEducation]].
 *
 * @see OrgPersonnelEducation
 */
class OrgPersonnelEducationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrgPersonnelEducation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrgPersonnelEducation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
