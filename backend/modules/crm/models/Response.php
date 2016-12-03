<?php

namespace backend\modules\crm\models;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgSite;
use common\models\User;
use Yii;
use backend\modules\crm\models\Survey;
use backend\modules\crm\models\ResponseSingle;
use backend\modules\crm\models\ResponseMultiple;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "qtn_response".
 *
 * @property string $id
 * @property string $survey_id
 * @property string $submitted
 * @property string $complete
 * @property string $username
 * @property string $table_name
 * @property integer $table_key
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $site_id
 * @property integer $customer_id
 */
class Response extends \yii\db\ActiveRecord
{

    //ช่วงเวลาที่จะค้นหา
    public  $duration;

    //ตั้งแต่วันที่ - ถึงวันที่
    public $dateStart;
    public $dateEnd;

    public  $datetime_string;
    public $exportToExel;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_id'], 'required'],
            [['survey_id', 'table_key', 'created_at', 'created_by', 'site_id', 'customer_id', 'seq', 'updated_by', 'updated_at','datetime'], 'integer'],
            [['submitted','datetime_string'], 'safe'],
            [['complete'], 'string'],
            [['username'], 'string', 'max' => 64],
            [['table_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_id' => 'แบบสอบถาม',
            'submitted' => 'วันที่แบบสอบถาม',
            'complete' => 'Complete',
            'username' => 'Username',
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'created_at' => 'บันทึกเข้าระบบเมื่อ',
            'created_by' => 'บันทึกโดย',
            'site_id' => 'ไซต์งาน/โครงการ',
            'customer_id' => 'รหัสลูกค้า',
            'seq' => 'ครั่งที่',
            'updated_at' => 'แก้ไขล่าสุด',
            'updated_by' => 'แก้ไขล่าโดย',
            'updated.firstname_th' => 'แก้ไขโดย',
            'created.firstname_th' => 'สร้างโดย',
            'duration' => 'ช่วงเวลาที่ต้องการค้นหา',
            'dateStart' => 'ตั้งแต่วันที่',
            'dateEnd' => 'ถึงวันที่',
            'datetime' => 'วันที่แบบสอบถาม',
            'exportToExel' => 'ส่งออกเป็นไฟล์ Exel',
        ];
    }

    /**
     * @inheritdoc
     * @return ResponseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponseQuery(get_called_class());
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'table_key']);
    }


    public function getSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }

    /**
     * หาคำตอบในประเภท radio
     * @return mixed
     */
    public function getResponseSingle()
    {
        // $model = ResponseSingle::find(['response_id' => $this->id])->asArray()->all();
        $model = $this->hasMany(ResponseSingle::className(), ['response_id' => 'id']);
        return $model;

    }


    /**
     * หาคำตอบในประเภท checkbox
     * @return mixed
     */
    public function getResponseMultiple()
    {
        $model = $this->hasMany(ResponseMultiple::className(), ['response_id' => 'id']);
        return $model;

    }


    /**
     * คำตอบในประเภท radio
     * @return mixed
     */

    public function getAnswerSingle()
    {
        $model = ResponseSingle::find()
            ->where(['response_id' => $this->id])
            ->all();
        return ArrayHelper::map($model, 'choice_id', 'choice_id');

    }


    /**
     * คำตอบในประเภท checkbox
     * @return mixed
     */
    public function getAnswerMultiple()
    {
        $models = ResponseMultiple::find()
            ->where(['response_id' => $this->id])
            ->all();
        return ArrayHelper::map($models, 'choice_id', 'choice_id');

    }

    /**
     * คำตอบในประเภท Text
     * @return mixed
     */
    public function getAnswerText()
    {
        $models = ResponseText::find()->where(['response_id' => $this->id])->all();
        return ArrayHelper::map($models, 'question_id', 'response');

    }

    /**
     * หาคำตอบอื่นซึ่ง คำตอบสามารถมีได้มากกว่า 1 รายการ
     * @param $questionId
     * @param $choiceId
     * @return mixed
     */
    public function getAnswerOthers($questionId, $choiceId)
    {
        $models = ResponseOther::find()->
        where([
            'response_id' => $this->id,
            'question_id' => $questionId,
            'choice_id' => $choiceId
        ])
            ->orderBy('seq')
            ->all();
        if ($models)
            return ArrayHelper::map($models, 'other_id', 'response');
    }




    /**
     * คำตอบในประเภท Other
     * @return mixed
     */
    /*    public function getAnswerOther()
        {
            $models = ResponseOther::find()->where(['response_id' => $this->id])->all();
            return ArrayHelper::map($models, 'choice_id', 'response');

        }*/



    public function getCreated()
    {
        return $this->hasOne(OrgPersonnel::className(), ['user_id' => 'created_by']);
    }


    public function getUpdated()
    {
        return $this->hasOne(OrgPersonnel::className(), ['user_id' => 'updated_by']);
    }




    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'created_by']);
    }

    public function getOrgPersonnel(){
        return $this->hasOne(OrgPersonnel::className(),['user_id'=>'created_by']);
    }

    public function getOrgSite(){
        return $this->hasOne(OrgSite::className(),['site_id'=>'site_id']);
    }

    public function getSiteItems(){
        $sites = OrgSite::find()->where(['active'=>1])->orderBy(['site_name'=>SORT_ASC])->all();
        return ArrayHelper::map($sites,'site_id','site_name');
    }


}
