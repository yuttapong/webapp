<?php

namespace backend\modules\org\models;

use common\models\SysAmphur;
use common\models\SysProvince;
use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/**
 * This is the model class for table "org_personnel".
 *
 * @property integer $id
 * @property string $code
 * @property integer $prefix_id
 * @property string $prefix_name_th
 * @property string $prefix_name_en
 * @property string $firstname_th
 * @property string $firstname_en
 * @property string $middlename_th
 * @property string $middlename_en
 * @property string $lastname_th
 * @property string $lastname_en
 * @property string $birthday
 * @property integer $day_probation
 * @property string $work_status
 * @property string $work_type
 * @property string $status
 * @property string $nationality
 * @property string $race
 * @property string $religion
 * @property string $idcard
 * @property string $blood
 * @property string $living_status
 * @property string $marriage_status
 * @property integer $idcard_province_id
 * @property integer $idcard_amphur_id
 * @property string $idcard_date_expiry
 * @property string $military_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class OrgPersonnel extends \yii\db\ActiveRecord
{
    const DIR_PHOTO = 'upload/personnel/';


    public $file;
    public $q;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_personnel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'firstname_th', 'lastname_th', 'work_status', 'work_type',
            ], 'required'],
            [['id', 'prefix_id', 'day_probation', 'idcard_province_id', 'idcard_amphur_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'active', 'weight', 'height'], 'integer'],
            [['birthday', 'idcard_date_expiry', 'start_working'], 'safe'],
            [['work_status', 'work_type', 'nationality', 'race', 'religion', 'blood', 'living_status', 'marriage_status', 'military_status'], 'string'],
            [['code'], 'string', 'max' => 11],
            [['prefix_name_th', 'prefix_name_en', 'q'], 'string', 'max' => 50],
            [['firstname_en', 'lastname_en', 'middlename_en', 'firstname_th', 'lastname_th', 'nickname'], 'string', 'max' => 60],
            [['middlename_th', 'photo'], 'string', 'max' => 100],
            [['idcard'], 'string', 'max' => 20],
            [['code'], 'unique'],
            [['file'], 'file', 'extensions' => 'png, jpg'],
            [['work_status'], 'default', 'value' => 'Working'],
            [['work_type'], 'default', 'value' => 'Probation'],
            [['active'], 'default', 'value' => 1],
            [['status'], 'integer'],
            [['firstname_th', 'lastname_th', 'firstname_en', 'lastname_en', 'code', 'idcard', 'birthday', 'nickname'], 'trim',]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'รหัสพนักงาน',
            'prefix_id' => 'รหัสคำนำหน้า',
            'prefix_name_th' => 'คำนำหน้า',
            'prefix_name_en' => 'คำนำหน้า(อังกฤษ)',
            'firstname_th' => 'ซื่อ',
            'firstname_en' => 'ชื่อ(อังกฤษ)',
            'middlename_th' => 'ชื่อกลาง',
            'middlename_en' => 'ชื่อกลาง(อังกฤษ)',
            'nickname' => 'ชื่อเล่น',
            'lastname_th' => 'นามสกุล',
            'lastname_en' => 'นามสกุล(อังกฤษ)',
            'birthday' => 'วันเกิด',
            'day_probation' => 'จำนวนวันที่ทดลองาน',
            'work_status' => 'สถานะทำงาน',
            'work_type' => 'ประเภทพนักงาน',
            'status' => 'สถานะ',
            'nationality' => 'สัญชาติ',
            'race' => 'เชื้อชาติ',
            'religion' => 'ศาสนา',
            'idcard' => 'บัตรประชาชน',
            'blood' => 'กลุ่มเลือด',
            'living_status' => 'สถานะความเป็นอยู่',
            'marriage_status' => 'สถานภาพสมรส',
            'idcard_province_id' => 'จังหวัดที่ออกบัตร',
            'idcard_amphur_id' => 'ออกให้ ณ เขต/อำเภอ',
            'idcard_date_expiry' => 'บัตรหมดอายุ',
            'military_status' => 'สถานะภาพทางทหาร',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขเมื่อ',
            'updated_by' => 'แก้ไขโดย',
            'idcardProvinceName' => 'ออกบัตรที่จังหวัด',
            'idcardAmphurName' => 'ออกให้ ณ เขต/อำเภอ',
            'active' => 'Active',
            'file' => 'ไฟล์รูปภาพ',
            'photo' => 'รูปภาพ',
            'educations' => 'ประวัติการศึกษา',
            'jobs' => 'ประวัติการทำงาน',
            'start_working' => 'เริ่มทำงาน',
            'height' => 'ส่วนสูง',
            'weight' => 'น้ำหนัก',


            // vitual field
            'fullnameTH' => 'ชื่อ-สกุล (ไทย)',
            'fullnameEN' => 'ชื่อ-สกุล (อังกฤษ)',
            'age' => 'อายุ',
            'militaryStatusName' => 'สถานภาพทางทหาร',
            'nationalityName' => 'สัญชาติ',
            'raceName' => 'เชื้อชาติ',
            'religionName' => 'ศาสนา',
            'bloodName' => 'หมู่โลหิต',
            'livingStatusName' => 'สถานะความเป็นอยู่',
            'marriageStatusName' => 'สถานภาพสมรส',
            'workTypeName' => 'ประเภท',
            'workStatusName' => 'สถานะ',
        ];
    }

    public function attributeHints()
    {
        return [
            'birthday' => 'วัน/เดือน/ปี ค.ศ.   เช่น : 31/12/2016',
            'idcard_date_expiry' => 'วัน/เดือน/ปี ค.ศ.   เช่น : 31/12/2016',
            'idcard' => 'ตัวเลข 13 หลัก',
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
            /*
            [
                'class' => '\yiidreamteam\upload\ImageUploadBehavior',
                'attribute' => 'photo',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'height' => 300],
                ],
                'filePath' => '@webroot/images/[[pk]].[[extension]]',
                'fileUrl' => '/images/[[pk]].[[extension]]',
                'thumbPath' => '@webroot/images/[[org_personnel]]_[[pk]].[[extension]]',
                'thumbUrl' => '/images/[[org_personnel]]_[[pk]].[[extension]]',
            ],
            */

        ];
    }


    /**
     * ชุดข้อมูล
     * @param $key
     * @return mixed
     */
    public function getItems($key)
    {
        $items = [
            //สถานะการทำงาน
            'workStatus' => [
                'Termination' => 'พ้นสภาพ',
                'Resignation' => 'ลาออก',
                'Suspended' => 'ถูกพักงาน',
                'Working' => 'ปฏิบัติงาน',
            ],
            //ประเภทพนักงาน
            'workType' => [
                'Normal' => 'ปกติ',
                'Temporary' => 'ชั่วคราว',
                'Probation' => 'ทดลองงาน',
                'Contract' => 'สัญญาจ้าง',
                'Application' => 'ผู้สมัครงาน',
                'Contractor' => 'ผู้รับเหมา',
                'Daily' => 'รายวัน',
                'Foreign' => 'ต่างด้าว',
                'Overtime' => 'นอกเวลา',
            ],
            //สถานภาพทางการทหาร
            'militaryStatus' => [
                'Exempted' => 'ได้รับการยกเว้น',
                'Pending' => 'ผ่อนผัน',
                'Conscripted' => 'ผ่านการเกณฑ์ทหารแล้ว',
                'Serving' => 'อยู่ระหว่างรับราชการทหาร',
            ],

            //สถานะความเป็นอยู่
            'livingStatus' => [
                1 => 'อาศัยอยุ่พ่อแม่',
                2 => 'ห้องเช่า',
                3 => 'บ้าน',
            ],

            //สถานภาพทางการสมรส
            'marriageStatus' => [
                'Single' => 'โสด',
                'Engaged' => 'หมั้น',
                'Married' => 'แต่งงานแล้ว',
                'Widowed' => 'หม้าย',
                'Separated' => 'แยกกันอยู่',
                'Divorced' => 'หย่าร้าง',
            ],

            //สัญชาติ
            'nationality' => [
                -1 => 'ไม่ระบุ',
                1 => 'ไทย',


            ],

            //เชื้อชาติ
            'race' => [
                'Thai' => 'ไทย',
                'Chinnees' => 'จีน',
            ],
            //ศาสนา
            'religion' => [
                'Buddhism' => 'ศาสนาพุทธ',
                'Christianity' => 'ศาสนาคริสต์',
                'Islam' => 'ศาสนาอิสลาม',
                'Hinduism' => 'ศาสนาพราหมณ์ – ฮินดู',
                'Zoroastrianism' => 'ศาสนาโซโรอัสเตอร์ ',
                'Jainism' => 'ศาสนาเชน',
                'Sikhism' => 'ศาสนาสิข',
                'Taoism' => 'ศาสนาเต๋า',
                'Confucius' => 'ศาสนาขงจื๊อ',
                'Shintoism' => 'ศาสนาชินโต',
                'Judaism' => 'ศาสนายิว',
                'Other' => 'อื่น ๆ',
            ],

            //กลุ่มเลือด
            'blood' => [
                'A' => 'A',
                'AB' => 'AB',
                'B' => 'B',
                'O' => 'O',
            ],
        ];

        return ArrayHelper::getValue($items, $key);
    }

    /**
     * สถานะการทำงาน
     * @return mixed
     */
    public function getWorkStatusItems()
    {
        return self::getItems('workStatus');
    }

    public function getWorkStatusName()
    {
        return @self::getItems('workStatus')[$this->work_status];
    }

    /**
     * ประเภทพนักงานหรือการทำงาน
     * @return mixed
     */
    public function getWorkTypeItems()
    {
        return self::getItems('workType');
    }

    public function getWorkTypeName()
    {
        return @self::getItems('workType')[$this->work_type];
    }

    /**
     * สถานภาพทางทหาร
     * @return mixed
     */
    public function getMilitaryStatusItems()
    {
        return self::getItems('militaryStatus');
    }

    public function getMilitaryStatusName()
    {
        return @self::getItems('militaryStatus')[$this->military_status];
    }

    /**
     * สถานะความเป็นอยู่
     * @return mixed
     */
    public function getLivingStatusItems()
    {
        return self::getItems('livingStatus');
    }

    public function getLivingStatusName()
    {
        return @self::getItems('livingStatus')[$this->living_status];
    }

    /**
     * สถานภาพสมรส
     * @return mixed
     */
    public function getMarriageStatusItems()
    {
        return self::getItems('marriageStatus');
    }

    public function getMarriageStatusName()
    {
        return @self::getItems('marriageStatus')[$this->marriage_status];
    }


    /**
     * ข้อมูลสัญชาติ
     * @return mixed
     */
    public function getNationalityItems()
    {
        return self::getItems('nationality');
    }

    public function getNationalityName()
    {
        return @self::getItems('nationality')[$this->nationality];
    }


    /**
     * ข้อมูลเชื้อชาติ
     * @return mixed
     */
    public function getRaceItems()
    {
        return self::getItems('race');
    }

    public function getRaceName()
    {
        return @self::getItems('race')[$this->race];
    }


    /**
     * ศาสนา
     * @return mixed
     */
    public function getReligionItems()
    {
        return self::getItems('religion');
    }

    public function getReligionName()
    {
        return @self::getItems('religion')[$this->religion];
    }


    /**
     * กรู๊ปเลือด
     * @return mixed
     */
    public function getBloodItems()
    {
        return self::getItems('blood');
    }

    public function getBloodName()
    {
        return @self::getItems('blood')[$this->blood];
    }


    /***
     * @return string
     */
    public static function getPhotoPath()
    {
        return Yii::getAlias('@webroot') . '/' . self::DIR_PHOTO;
    }

    /**
     * @return string
     */
    public static function getPhotoUrl()
    {
        return Url::base(true) . '/' . self::DIR_PHOTO;
    }


    public function getPhotoThumbnailLink()
    {
        $photo = '';
        if (($this->photo)) {
            $photo = Url::base(true) . '/' . self::DIR_PHOTO . $this->id . '/thumbnail/' . $this->photo;
        }
        return $photo;

    }


    /**
     * @param $user_id
     * @param $event_name
     * @return array
     */
    public function getPhtoThumbnails($id, $event_name)
    {
        $uploadFiles = OrgPersonnel::find()->where(['id' => $id])->all();
        $preview = [];
        foreach ($uploadFiles as $file) {
            $preview[] = [
                'url' => self::getPhotoUrl(true) . $id . '/' . $file->real_filename,
                'src' => self::getPhotoUrl(true) . $id . '/thumbnail/' . $file->real_filename,
                'options' => ['title' => $event_name]
            ];
        }
        return $preview;
    }


    /**
     * @inheritdoc
     * @return OrgPersonnelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgPersonnelQuery(get_called_class());
    }

    /**
     * ชื่อ - สกุล ไทย
     * @return string
     */
    public function getFullnameTH()
    {
        return $this->firstname_th . ' ' . $this->lastname_th;
    }

    /**
     * ชื่อ-สกุล อังกฤษ
     * @return string
     */
    public function getFullnameEN()
    {
        return $this->firstname_en . ' ' . $this->lastname_en;
    }


    /**
     * อายุ ซึ่งหาจากวันเกิด
     * @return mixed
     */
    public function getAge()
    {
        $query = (new Query())
            ->select("TIMESTAMPDIFF( YEAR, birthday, CURDATE( ) ) AS  age")
            ->from("org_personnel")
            ->where(['id' => $this->id])
            ->one();
        return $query['age'];
    }

    /**
     * ชื่อสถาบันที่จบล่าสุด
     * @return string
     */
    public function getLatestEductionName()
    {
        $model = OrgPersonnelEducation::find()
            ->where(['personnel_id' => $this->id])
            ->orderBy(['end_year' => SORT_DESC])
            ->limit(1)
            ->one();
        if ($model) {
            $year = $model->end_year > 0 ? " ({$model->end_year})" : '';
            return $model->education_name . $year;
        }

    }


    /**
     * ประวัติการศึกษา
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(OrgPersonnelEducation::className(), ['personnel_id' => 'id'])->orderBy('sorter');
    }


    /**
     * ประวัติการทำงาน
     * @return \yii\db\ActiveQuery
     */
    public function getWorks()
    {
        return $this->hasMany(OrgPersonnelWork::className(), ['personnel_id' => 'id'])->orderBy('seq');
    }


    /**
     * ข้อมูลตำแหน่ง
     * @return \yii\db\ActiveQuery
     */
    public function getPositions()
    {
        return $this->hasMany(OrgPersonnelPosition::className(), ['personnel_id' => 'id'])->orderBy('sorter');
    }

    public function getJobTerminationRemark()
    {
        return $this->hasMany(OrgPersonnelWork::className(), ['personnel_id' => 'id']);

    }

    public function getGalleries()
    {
        return $this->hasMany(OrgGallery::className(), ['user_id' => 'id']);

    }


    public function getJobReasonLeaving()
    {
        return $this->hasMany(OrgReasonForLeaving::className(), ['personnel_id' => 'id']);
    }

    /**
     * ข้อมูลจังหวัด
     * @return \yii\db\ActiveQuery
     */
    public function getSysProvince()
    {
        return $this->hasOne(SysProvince::className(), ['id' => 'idcard_province_id']);
    }

    /**
     * ข้อมูลอำเภอ
     * @return \yii\db\ActiveQuery
     */
    public function getSysAmphur()
    {
        return $this->hasOne(SysAmphur::className(), ['id' => 'idcard_amphur_id']);
    }


    /**
     * ชื่อจังหวัดที่ออกบัตรประชาชน
     * @return mixed
     */
    public function getIdcardProvinceName()
    {
        return @$this->sysProvince->name_th;
    }

    /**
     * ชื่ออำเภอที่ออกบัตรประชาชน
     * @return mixed
     */
    public function getIdcardAmphurName()
    {
        return @$this->sysAmphur->name_th;
    }

    //ชื่อสกุลพร้อมรหัสพนักงาน
    public function getFullnameWithCode()
    {
        return $this->getFullnameTH() . " ({$this->code})";
    }


    /**
     * ออกรหัสพนักงาน (Code)
     * @return string
     */
    public function getGenerateNewCode()
    {
        return (date('y') + 43) . sprintf("%04d", rand(0200, 9999));
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function sendEmailResetPwd()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'username' => $this->code,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return \Yii::$app->mailer->compose([
                    'html' => 'passwordResetToken-html',
                    'text' => 'passwordResetToken-text'
                ],
                    ['user' => $user]
                )
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($user->email)
                    ->setSubject('Password reset for ' . \Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }

}
