<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[GooglePlaceGps]].
 *
 * @see GooglePlaceGps
 */
class GooglePlaceGpsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GooglePlaceGps[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GooglePlaceGps|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
