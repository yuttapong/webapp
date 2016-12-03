<?php

namespace backend\modules\qtn\models;

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
            [[ 'status'], 'integer'],
            [['name', 'owner', 'realm', 'title'], 'required'],
            [['public', 'subtitle', 'info', 'thank_body'], 'string'],
            [['changed'], 'safe'],
            [[ 'realm', 'email', 'theme'], 'string', 'max' => 64],
            [['owner'], 'string', 'max' => 16],
            [['name','title', 'thanks_page', 'thank_head'], 'string', 'max' => 255],
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
            'name' => 'Name',
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
        ];
    }
    public function getSurvey(){
    	$datas = Survey::find()->all();
    	return ArrayHelper::map($datas,'id','name');
    }
    public function getSurveyTabs()
    { 
    	return $this->hasMany(SurveyTab::className(), ['survey_id' => 'id']);
    }
}
