<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "google_place_gps".
 *
 * @property integer $id
 * @property integer $place_id
 * @property string $gps
 *
 * @property GooglePlaces $place
 */
class GooglePlaceGps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'google_place_gps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'gps'], 'required'],
            [['place_id'], 'integer'],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => GooglePlaces::className(), 'targetAttribute' => ['place_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'place_id' => 'Place ID',
            'gps' => 'Gps',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(GooglePlaces::className(), ['id' => 'place_id']);
    }

    /**
     * @inheritdoc
     * @return GooglePlaceGpsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GooglePlaceGpsQuery(get_called_class());
    }
}
