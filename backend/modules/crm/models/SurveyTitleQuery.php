<?php

namespace backend\modules\crm\models;

/**
 * This is the ActiveQuery class for [[SurveyTitle]].
 *
 * @see SurveyTitle
 */
class SurveyTitleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SurveyTitle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SurveyTitle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
