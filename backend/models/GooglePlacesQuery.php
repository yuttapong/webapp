<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[GooglePlaces]].
 *
 * @see GooglePlaces
 */
class GooglePlacesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/



    /**
     * @inheritdoc
     * @return GooglePlaces[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GooglePlaces|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }



}
