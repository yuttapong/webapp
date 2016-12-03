<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "google_places".
 *
 * @property integer $id
 * @property string $name
 * @property integer $place_type
 * @property string $google_place_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class GooglePlaces extends \yii\db\ActiveRecord
{





    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'google_places';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['google_place_id','full_address','notes','vicinity'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ชื่อสถานะที่',
            'place_type' => 'ประเภทสถานที่',
            'google_place_id' => 'รหัสสถานะที่',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขล่าสุด',
            'updated_by' => 'แก้ไขโดย',
            'full_address' => 'ที่อยู่',
            'placeTypeName' => 'ประเภท',
        ];
    }



    /**
     * @inheritdoc
     * @return GooglePlacesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GooglePlacesQuery(get_called_class());
    }



    const TYPE_OTHER = 0;
    const TYPE_RESTAURANT = 10;
    const TYPE_COFFEESHOP = 20;
    const TYPE_RESIDENCE = 30;
    const TYPE_OFFICE = 40;
    const TYPE_BAR = 50;
    public  $searchbox;


    public function  behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }



    public function getPlaceType($data)
    {
        $options = $this->getPlaceTypeOptions();
        return $options[$data];
    }

    public function getPlaceTypeOptions()
    {
        return array(
            self::TYPE_RESTAURANT => 'ร้านอาหาร, ภัตตาคาร',
            self::TYPE_COFFEESHOP => 'ร้านกาแฟ',
            self::TYPE_RESIDENCE => 'ที่อยุ่อาศัย, บ้านพัก',
            self::TYPE_OFFICE => 'สำนักงาน',
            self::TYPE_BAR => 'บาร์',
            self::TYPE_OTHER => 'อื่น ๆ'
        );
    }

    public function getPlaceTypeName()
    {
        $options = $this->getPlaceTypeOptions();
        return @$options[$this->place_type];
    }


    public function addGeometryByPoint($model, $lat, $lon)
    {
        $pg = new GooglePlaceGps;
        $pg->place_id = $model->id;
        $pg->gps = new \yii\db\Expression("GeomFromText('Point(" . $lat . " " . $lon . ")')");
        $pg->crated_at = time();
        $pg->save();
    }

    public function getLocation($place_id='')
    {
        $model = GooglePlaceGps::find()
            ->select("AsText(gps) as gps")
            ->where(['place_id'=>$place_id])
            ->one();
        $gps = new \stdClass;
        if (is_null($model)) {
            return false;
        } else {
            list($gps->lat, $gps->lng) = $this->extractPoint($model->gps);
        }
        return $gps;
    }


    private  function extractPoint($string) {
        $string = str_replace('point(', '', strtolower($string)); // remove leading bracket
        $string = str_replace(')', '', $string); // remove trailing bracket
        return explode(' ', $string);
    }

    public function addGeometry($model,$location) {
        $x = json_decode($location,true);
        reset($x);
        $lat = current($x);
        $lon = next($x);
        $pg = new GooglePlaceGps;
        $pg->place_id=$model->id;
        $pg->gps = new \yii\db\Expression("GeomFromText('Point(".$lat." ".$lon.")')");
        $pg->save();
    }


}
