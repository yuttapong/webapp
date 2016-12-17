<?php

namespace backend\modules\crm\models;

use backend\modules\org\models\OrgSite;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "qtn_survey".
 *
 * @property string $id
 * @property integer $module_id
 * @property string $name
 * @property string $owner
 * @property string $realm
 * @property string $public
 * @property string $status
 * @property string $title
 * @property string $email
 * @property string $subtitle
 * @property string $info
 * @property string $theme
 * @property string $thanks_page
 * @property string $thank_head
 * @property string $thank_body
 * @property string $changed
 */
class Survey extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_survey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'site_id', 'module_id'], 'integer'],
            [['name', 'owner', 'realm', 'title'], 'required'],
            [['public', 'subtitle', 'info', 'thank_body'], 'string'],
            [['changed'], 'safe'],
            [['realm', 'email', 'theme'], 'string', 'max' => 64],
            [['owner'], 'string', 'max' => 16],
            [['name', 'title', 'thanks_page', 'thank_head'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ชื่อแบบสอบถาม',
            'owner' => 'Owner',
            'realm' => 'Realm',
            'public' => 'Public',
            'status' => 'Status',
            'title' => 'Title',
            'email' => 'Email',
            'subtitle' => 'Subtitle',
            'info' => 'Info',
            'theme' => 'Theme',
            'thanks_page' => 'Thanks Page',
            'thank_head' => 'Thank Head',
            'thank_body' => 'Thank Body',
            'changed' => 'Changed',
            'site_id' => 'ไซต์ ',
            'module_id' => 'Module Id'
        ];
    }

    /**
     * ข้อมูลแบบสอบถาม
     */
    public function getQuestionnaires(){
        return $this->hasMany(Response::className(),['survey_id'=>'id']);
    }


    public function getSurvey()
    {
        $datas = Survey::find()->all();
        return ArrayHelper::map($datas, 'id', 'name');
    }


    public function getSurveyTabs()
    {
        return $this->hasMany(SurveyTab::className(), ['survey_id' => 'id']);
    }

    public  function getSite(){
        return $this->hasOne(OrgSite::className(),['site_id'=>'site_id'])->orderBy('site_name');
    }

    public function getSiteItems(){
        $model = OrgSite::find()->all();
        return ArrayHelper::map($model,'site_id','site_name');
    }

    public  static  function getSurveyItems(){
        $model = Survey::find()->orderBy('site_id')->all();
        foreach ($model as $m){
            $data[$m->id] = $m->site->site_name.':::  '. $m->name;
        }
        return $data;
        //return ArrayHelper::map($model,'id','name');
    }
    

    /**
     * นับจำนวนที่พนักงานทำแบบสอบถาม
     * @param $userId
     * @return int|string
     */
    public static function countSurveyByUser($surveyId,$userId)
    {
        $count = Response::find()
            ->where([
                'survey_id' => $surveyId,
                'created_by' => $userId,
            ])
            ->count();
        return $count;
    }

    /**
     * นับจำนวนลูกค้าทำแบบสอบถาม
     * @param $userId
     * @return int|string
     */
    public static function countSurveyByCustomer($surveyId,$customerId)
    {
        $count = Response::find()
            ->where([
                'survey_id' => $surveyId,
                'customer_id' => $customerId,
            ])
            ->count();
        return $count;
    }


    public function getQuestions(){
        return $this->hasMany(Question::className(),['survey_id'=>'id'])->orderBy('seq');
    }
}
