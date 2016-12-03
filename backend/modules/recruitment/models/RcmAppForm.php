<?php

namespace backend\modules\recruitment\models;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgPosition;
use backend\modules\org\models\OrgCompany;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\helpers\Html;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "rcm_app_form".
 *
 * @property integer $id
 * @property string $code
 * @property string $email
 * @property string $pwd
 * @property string $photo
 * @property integer $company_id
 * @property string $salary_desired
 * @property integer $personnel_id
 * @property string $interview_status
 * @property string $type
 * @property string $status
 * @property string $description
 * @property integer $position_id
 * @property string $position_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $lock
 */
class RcmAppForm extends \yii\db\ActiveRecord
{

    const  SESSION_NAME = 'RCM-FORM';

    const  CODE_TABLE_NAME = 'rcm_app_form'; // table_id จากตาราง sys_table
    const  CODE_STRING = 'AP'; //ตัวษรสำหรับใช้ในออกรูปแบบโค้ด
    const  PHOTO_PATH = 'upload/resume/'; //โฟล์เดอร์เก็บรูปภาพ

    //ตำแหน่งที่สมัคร
    public $positionApply = [];

    const STATUS_CANCELED = -1;
    const STATUS_APPLY = 1;
    const STATUS_PENDING = 2;
    const STATUS_PASSED = 3;
    const STATUS_NOT_PASSED = 4;

    public $q;
    public $imageFile;
    public $firstname;
    public $lastname;
    public $fullname;



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
            [['salary_desired'], 'required'],
            [['positionApply'], 'required','on'=>'insert'],
            [['positionApply'], 'required','on'=>'update'],
            [['company_id', 'personnel_id', 'position_id', 'created_at',
                'created_by', 'updated_at', 'updated_by', 'pwd','status'], 'integer'],
            [['interview_status', 'description', 'position_apply'], 'string'],
            [['code', 'position_apply'], 'string', 'max' => 60],
            [['email', 'photo', 'salary_desired', 'position_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('recruitment', 'ID'),
            'code' => Yii::t('recruitment', 'เลขที่สมัคร'),
            'email' => Yii::t('recruitment', 'Email'),
            'pwd' => Yii::t('recruitment', 'รหัสผ่าน'),
            'photo' => Yii::t('recruitment', 'รูปภาพ'),
            'company_id' => Yii::t('recruitment', 'Company ID'),
            'salary_desired' => Yii::t('recruitment', 'เงินเดือนที่ต้องการ'),
            'personnel_id' => Yii::t('recruitment', 'Personnel ID'),
            'interview_status' => Yii::t('recruitment', 'สถานะสัมภาษณ์'),
            'type' => Yii::t('recruitment', 'ประเภท'),
            'status' => Yii::t('recruitment', 'สถานะใบสมัคร'),
            'description' => Yii::t('recruitment', 'รายละเอียด'),
            'position_id' => Yii::t('recruitment', 'ตำแหน่ง '),
            'position_name' => Yii::t('recruitment', 'Position Name'),
            'created_at' => Yii::t('recruitment', 'วันที่'),
            'created_by' => Yii::t('recruitment', 'Created By'),
            'updated_at' => Yii::t('recruitment', 'Updated At'),
            'updated_by' => Yii::t('recruitment', 'Updated By'),
            'positionApply' => Yii::t('recruitment', 'ตำแหน่งที่สมัคร'),
            'imageFile' => Yii::t('recruitment', 'รูปภาพ'),
            'fullname' => Yii::t('recruitment', 'ชื่อ-สกุล'),
            'statusName' =>Yii::t('recruitment', 'สถานะใบสมัคร'),
        ];
    }

    /**
     * @inheritdoc
     * @return RcmAppFormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RcmAppFormQuery(get_called_class());
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

    public function getItems($key)
    {
        $items = [
            'status' => [
                self::STATUS_APPLY => 'กรอกใบสมัคร',
                self::STATUS_PENDING => 'รอสัมภาษณ์',
                self::STATUS_CANCELED => 'ยกเลิก',
                self::STATUS_PASSED => 'ผ่านสัมภาษณ์',
                self::STATUS_NOT_PASSED => 'ไม่ผ่านสัมภาษณ์',

            ],
        ];
        return ArrayHelper::getValue($items, $key);
    }

    public function getStatusItems()
    {
        return self::getItems('status');
    }

    public function getStatusName()
    {
        return @self::getItems('status')[$this->status];
    }

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
                $filename = $this->id . '[' . $this->code . ']_' . uniqid() . '.' . $this->imageFile->extension;
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
        return isset($this->photo) ? 'http://localhost/siricenter/frontend/web/' . self::PHOTO_PATH . $this->photo : null;
    }

    public function getPhotoPath()
    {
        return Yii::getAlias('@frontend') . '/web/' . self::PHOTO_PATH . $this->photo;

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
            $data[$model->position->id] = $label;
        }
        $data = OrgPosition::find()->orderBy('name_th')->all();
        return ArrayHelper::map($data, 'id', 'name_th');

    }

    /**
     *
     */
    public function getApplyPositions()
    {
        return $this->hasMany(RcmAppFormPosition::className(), ['app_form_id' => 'id'])->orderBy('seq');
    }

    public function getShowApplyPosition(){
        $html = '';
        if ($positions = $this->applyPositions) {
            $html = '';
            $loop = 1;
            foreach ($positions as $p) {
                $number = count($positions)>1?$loop.') ':'';
                $html .= Html::tag('p', $number . $p->position->name_th,['class'=>'']);
                $loop++;
            }

        }
        return $html;
    }
}
