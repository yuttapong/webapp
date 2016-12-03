<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[SurveyTab]].
 *
 * @see SurveyTab
 */
class SurveyTabQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SurveyTab[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SurveyTab|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
