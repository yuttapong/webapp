<?php

namespace backend\modules\recruitment\models;

use backend\modules\org\models\OrgPosition;
use Yii;

/**
 * This is the model class for table "rcm_app_form_position".
 *
 * @property integer $app_form_id
 * @property integer $position_id
 * @property string $position_name
 * @property integer $seq
 */
class RcmAppFormPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rcm_app_form_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_form_id', 'position_id', 'seq'], 'required'],
            [['app_form_id', 'position_id', 'seq'], 'integer'],
            [['position_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'app_form_id' => Yii::t('app', 'App Form ID'),
            'position_id' => Yii::t('app', 'Position ID'),
            'position_name' => Yii::t('app', 'Position Name'),
            'seq' => Yii::t('app', 'Seq'),
        ];
    }

    public  function getPosition(){
        return $this->hasOne(OrgPosition::className(),['id'=>'position_id']);
    }
}
