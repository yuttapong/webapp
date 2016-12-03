<?php

namespace backend\modules\recruitment\models;

use backend\modules\org\models\OrgJobOption;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rc_app_property".
 *
 * @property integer $id
 * @property integer $app_manpower_id
 * @property integer $table_id
 * @property integer $table_key
 * @property integer $create_at
 * @property integer $create_id
 */
class RcmAppProperty extends \yii\db\ActiveRecord
{

    // ประเภทหน้าที่รับผิดชอบ
    const TYPE_RESPONSIBILITY = 'responsibility';

    // ประเภทคุณสมบัติผู้สมัคร
    const TYPE_PROPERTY = 'property';

    
    //สวัสดิการ
    const TYPE_BENEFIT = 'benefit';




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rcm_app_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'app_manpower_id', 'table_id', 'job_option_id', 'created_at', 'created_by'], 'required'],
            [['id', 'app_manpower_id', 'table_id', 'job_option_id', 'created_at', 'created_by','sorter'], 'integer'],
            [['_type','title'],'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_manpower_id' => 'App Manpower ID',
            'table_id' => 'Table ID',
            'job_option_id' => 'Option ID',
            'create_at' => 'Create At',
            'create_id' => 'Create ID',
            '_type' => 'Type',
            'title' => 'หัวข้อ',
        ];
    }

    /**
     * @inheritdoc
     * @return RcmAppManpowerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RcmAppManpowerQuery(get_called_class());
    }

    /*
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }
    */
    
}
