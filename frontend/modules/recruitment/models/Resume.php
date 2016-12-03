<?php

namespace frontend\modules\recruitment\models;

use backend\modules\org\models\OrgCompany;
use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgPosition;
use backend\modules\recruitment\models\RcmAppManpower;
use Yii;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "rcm_app_form".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $salary_desired
 * @property integer $personnel_id
 * @property string $interview_status
 * @property string $type
 * @property string $status
 * @property string $description
 * @property string $position_id
 * @property integer $created_at
 * @property integer $created_by
 */
class Resume extends \yii\db\ActiveRecord
{

    const  SESSION_NAME = 'RCM-FORM';

    const  CODE_TABLE_NAME = 'rcm_app_form'; // table_id จากตาราง sys_table
    const  CODE_STRING = 'AP'; //ตัวษรสำหรับใช้ในออกรูปแบบโค้ด
    const  PHOTO_PATH = 'upload/resume/'; //โฟล์เดอร์เก็บรูปภาพ

    public $imageFile;

    public $positionApply;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rcm_app_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['positionApply', 'salary_desired'], 'required'],
            [['pwd', 'company_id', 'personnel_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'position_id', 'pwd'], 'integer'],
            [['interview_status', 'type', 'status', 'description', 'code', 'position_name', 'photo','position_apply'], 'string'],
            [['salary_desired'], 'string', 'max' => 60],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'เลขที่สมัคร',
            'company_id' => 'Company ID',
            'salary_desired' => 'เงินเดือนที่ต้องการ บาท/เดือน',
            'personnel_id' => 'ผู้สมัคร',
            'interview_status' => 'สถานะสัมภาษณ์',
            'type' => 'ประเภท',
            'status' => 'สถานะ',
            'description' => 'Description',
            'position_id' => 'ตำแหน่ง ',
            'position_name' => 'ตำแหน่งที่สมัคร ',
            'created_at' => 'เวลาที่สมัคร',
            'created_by' => 'Created By',
            'updated_at' => 'แก้ไลล่าสุด',
            'updated_by' => 'แก้ไขโดย',
            'photo' => 'รูปภาพ',
            'imageFile' => 'รูปภาพ',
            'pwd' => 'รหัสผ่าน',
        ];
    }

    public function attributeHints()
    {
        return [
            'salary_desired' => 'เช่น 12,000 - 15,000',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     * @return RcmAppFormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResumeQuery(get_called_class());
    }

    /*
        function behaviors()
        {
            return [
                [
                    'class' => UploadBehavior::className(),
                    'attribute' => 'imageFile', // required, use to receive input file
                    'savedAttribute' => 'photo', // optional, use to link model with saved file.
                    'uploadPath' => '@common/upload/resume', // saved directory. default to '@runtime/upload'
                    'autoSave' => true, // when true then uploaded file will be save before ActiveRecord::save()
                    'autoDelete' => true, // when true then uploaded file will deleted before ActiveRecord::delete()
                ],
            ];
        }
    */

    public function getCompany()
    {
        return $this->hasOne(OrgCompany::className(), ['id' => 'company_id']);
    }


    public function getPersonnel()
    {
        return $this->hasOne(OrgPersonnel::className(), ['id' => 'personnel_id']);
    }

    public function getPosition()
    {
        return $this->hasOne(OrgPosition::className(), ['id' => 'position_id']);
    }


    /**
     * ชื่อหัวหน้างาน
     * @return string
     */
    public function getLeaderName()
    {
        return @$this->findPersonnelName($this->leader_user_id);
    }

    /**
     * ชือ่ผู้อนุมัติ
     * @return string
     */
    public function getApproverName()
    {
        return @$this->findPersonnelName($this->approver_user_id);
    }

    /**
     * ชื่อบริษัท
     * @return mixed
     */
    public function getCompanyName()
    {
        return @$this->company->name;
    }

    /**
     * ชื่อผู้อนุมัติคนต่อไป
     * @return string
     */
    public function getUserNextName()
    {
        return @$this->findPersonnelName($this->user_next_id);
    }

    /**
     * ชือตำแหน่ง
     * @return mixed
     */
    public function getPositionName()
    {
        return @$this->position->name_th;
    }


    /**
     * หาชื่อบุคลากรจาก id
     * @param $user_id
     * @return string
     */
    private function findPersonnelName($user_id)
    {
        $model = OrgPersonnel::find()
            ->select('firstname_th,lastname_th')
            ->where(['user_id' => $user_id])
            ->one();
        if ($model)
            return $model->firstname_th . ' ' . $model->lastname_th;
    }

    /**
     * Upload photo
     * @return bool
     */
    public function upload()
    {
        $path = $this->getPathUpload();
        if (!is_dir($path)) {
            BaseFileHelper::createDirectory($path, 0777, true);
        }
        $oldPhoto = $this->getPhotoPath();
        if ($this->validate()) {
            if ($this->imageFile != false) {
                if (is_file($oldPhoto)) {
                    @unlink($oldPhoto);
                }
                $filename = $this->code . '_' . uniqid() . '.' . $this->imageFile->extension;
                $result = $this->imageFile->saveAs($path . $filename, true);
                if ($result) {
                    $fileName = $path . $filename;
                    $newWidth = 150;
                    $newHeight = 150;
                    $savePath = $path . $filename;
                    Image::getImagine()
                        ->open($fileName)
                        ->thumbnail(new Box($newWidth, $newHeight))
                        ->save($savePath, ['quality' => 90]);
                    return $filename;
                }
            }
        }
    }

    public function getPhotoUrl()
    {
        return isset($this->photo) ? Yii::$app->urlManager->getBaseUrl() . '/' . self::PHOTO_PATH . $this->photo : null;
    }

    public function getPhotoPath()
    {
        return isset($this->photo) ? $this->getPathUpload() . $this->photo : null;

    }


    public function getPathUpload()
    {
        return Yii::getAlias('@frontend') . '/web/' . self::PHOTO_PATH;
    }


    /**
     * ตำแหน่งที่เปิดรับทั้งหมด
     * @return mixed
     */
    public function getPositionAvailableList()
    {
        $models = RcmAppManpower::find()
            //->where(['status'=> RcmAppManpower::APPROVE_COMPLETED])
            ->all();
        foreach ($models as $model) {
            $salary = $model->salary ? ' (' . number_format($model->salary) . ')' : '';
            $label = $model->code . ': ' . $model->position->name_th . $salary;
            $data[$model->id] = $label;
        }
        return $data;

    }

}
