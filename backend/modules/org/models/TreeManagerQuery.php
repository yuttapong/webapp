<?php


namespace backend\modules\org\models;

/**
 * This is the ActiveQuery class for [[TreeManager]].
 *
 * @see TreeManager
 */
class TreeManagerQuery extends \yii\db\ActiveQuery
{
    public $company_id;
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TreeManager[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TreeManager|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
