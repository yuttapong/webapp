<?php

namespace backend\modules\org\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "org_job_option".
 *
 * @property integer $id
 * @property integer $position_id
 * @property string $_type
 * @property string $title
 * @property integer $create_at
 * @property integer $create_id
 *
 * @property OrgPosition $position
 */

class OrgJobOption extends \yii\db\ActiveRecord
{

    // ประเภทหน้าที่รับผิดชอบ
    const TYPE_RESPONSIBILITY = 'responsibility';

    // ประเภทคุณสมบัติผู้สมัคร
    const TYPE_PROPERTY = 'property';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_job_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['master_id', 'created_at', 'created_by','updated_at','updated_by','sorter'], 'integer'],
            [['_type'], 'string'],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            '_type' => 'Type',
            'title' => 'Title',
            'created_at' => 'Create At',
            'created_by' => 'Create ID',
            'updated_at' => 'Uddate At',
            'updated_by' => 'Update ID',
        ];
    }

    function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }
    
}
