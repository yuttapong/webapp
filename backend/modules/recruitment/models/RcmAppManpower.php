<?php

namespace backend\modules\recruitment\models;

use backend\modules\org\models\OrgCompany;
use backend\modules\org\models\OrgJobOption;
use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgPosition;
use backend\modules\org\models\OrgDepartment;
use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "rc_app_manpower".
 *
 * @property integer $id
 * @property string $code
 * @property integer $position_id
 * @property integer $department_id
 * @property integer $leader_user_id
 * @property integer $approver_user_id
 * @property integer $approver_seq
 * @property integer $user_next_id
 * @property integer $company_id
 * @property string $reason_request
 * @property string $reason_request_text
 * @property string $data_property
 * @property integer $status
 * @property string $log_status
 * @property string $date_to
 * @property string $salary
 * @property integer $qty
 * @property integer $created_at
 * @property integer $created_by
 */
class RcmAppManpower extends \yii\db\ActiveRecord
{

    const  CODE_TABLE_NAME = 'rcm_app_manpower'; // table_id จากตาราง sys_table
    const  CODE_STRING = 'RC'; //ตัวษรสำหรับใช้ในออกรูปแบบโค้ด

    //สถานะ
    const  LOG_STATUS_DELETED = 'delete';
    const  LOG_STATUS_ACTIVE = 'normal';

    const SYS_DOCUMENT_ID =  1;

    const  APPROVE_NOT_COMPLETED = 0; //อนุมัติยังไม่เสร็จสมบูรณ์
    const  APPROVE_COMPLETED = 1; //อนุมัติเสร็จครบแล้ว


    public $search_resonsibility;
    public $search_property;
    public $search_benefit;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rcm_app_manpower';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_id', 'department_id', 'leader_user_id', 'company_id', 'status', 'date_to', 'qty', 'reason_request'], 'required'],
            [['position_id', 'department_id', 'leader_user_id', 'reason_request',
                'approver_user_id', 'approver_seq', 'user_next_id',
                'company_id', 'status', 'qty', 'created_at', 'created_by', 'updated_at', 'updated_by'
            ], 'integer'],
            [['data_property', 'log_status', 'code'], 'string'],
            [['date_to'], 'safe'],
            [['code'], 'string', 'max' => 10],
            [['reason_request_text', 'salary'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'position_id' => 'ตำแหน่งงาน',
            'department_id' => 'แผนก',
            'leader_user_id' => 'หัวหน้างาน',
            'approver_user_id' => 'ผู้อนุมัติ',
            'approver_seq' => 'Approver Seq',
            'user_next_id' => 'User Next ID',
            'company_id' => 'บริษัท',
            'reason_request' => 'เหตุผลในการขอ',
            'reason_request_text' => 'เห็นผลในการขออื่น ๆ',
            'data_property' => 'เอาไว้คุณสมบัติ',
            'status' => 'สถานะอนุมัติ',
            'log_status' => 'Log Status',
            'date_to' => Yii::t('app','วันที่ต้องการ'),
            'salary' => Yii::t('app','เงินเดือน'),
            'qty' => 'จำนวนที่ต้องการ',
            'created_at' => 'ทำรายการเมื่อ',
            'created_date' => 'วันที่',
            'created_by' => 'โดย',
            'requestBy' => 'ผู้ขอ',
            'logStatusName' => 'Log Status',
        ];
    }

    /**
     * @param $key
     * @return mixed
     */
    private function getItems($key)
    {
        $items = [
            'reasonRequestType' => [
                1 => 'ตำแหน่งเดิมพนักงานลาออก',
                2 => 'เพิ่มตำแหน่งใหม่',
                3 => 'ปฏิบัติงานชั่วคราว',
                -1 => 'อื่น ๆ ',
            ],
            'statusApprove' => [
                self::APPROVE_NOT_COMPLETED => 'ยังไม่สมบูรณ์',
                self::APPROVE_COMPLETED => 'อนุมัติครบแล้ว',
            ],
        ];
        return ArrayHelper::getValue($items, $key);
    }

    protected function checkCodeExist()
    {


    }

    /**
     * @return mixed
     */
    public function getReasonRequestTypeItems()
    {
        return $this->getItems('reasonRequestType');
    }


    /**
     * @return mixed
     */
    public function getStatusApproveItems()
    {
        return $this->getItems('statusApprove');
    }


    /**
     * @return mixed
     */
    public function getReasonRequestName()
    {
         return ArrayHelper::getValue($this->getReasonRequestTypeItems(),$this->reason_request);
    }


    public function attributeHints()
    {
        return [
            'salary' => 'เช่น 20000-35000',
        ];

    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    public function getLogStatusName()
    {
        $log = RcmAppManpower::getItemLogStatus();
        return $log[$this->log_status];
    }

    /**
     * @inheritdoc
     * @return RcmAppManpowerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RcmAppManpowerQuery(get_called_class());
    }

    public function getItemLogStatus()
    {
        return [
            self::LOG_STATUS_ACTIVE => 'ใช้งานอยู่',
            self::LOG_STATUS_DELETED => 'ลบแล้ว',
        ];
    }

    public function getPosition()
    {
        return $this->hasOne(OrgPosition::className(), ['id' => 'position_id']);
    }

    public function getDepartment()
    {
        return $this->hasOne(OrgDepartment::className(), ['id' => 'department_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(OrgCompany::className(), ['id' => 'company_id']);
    }


    public function getOptionResponsibilities()
    {
        return $this->hasMany(RcmAppProperty::className(), ['app_manpower_id' => 'id'])
            ->where(['_type' => RcmAppProperty::TYPE_RESPONSIBILITY])->orderBy('sorter');
    }


    public function getOptionProperties()
    {
        return $this->hasMany(RcmAppProperty::className(), ['app_manpower_id' => 'id'])
            ->where(['_type' => RcmAppProperty::TYPE_PROPERTY])->orderBy('sorter');
    }


    public function getOptionBenefits()
    {
        return $this->hasMany(RcmAppProperty::className(), ['app_manpower_id' => 'id'])
            ->where(['_type' => RcmAppProperty::TYPE_BENEFIT])->orderBy('sorter');
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
     * ชือผู้ทำรายการ
     * @return string
     */
    public function getRequestBy()
    {
        $user = User::findOne($this->created_by);
        $model = OrgPersonnel::findOne(['user_id' => $user->id]);
        return $model->fullnameTH;
    }


    /**
     * ข้อมูลตำแหน่ง
     * @return array
     */
    public function getPositionList()
    {
        $models = OrgPosition::find()
            ->select('id,name_th')
            ->orderBy('name_th')
            ->asArray()
            ->all();
        return ArrayHelper::map($models, 'id', 'name_th');
    }


    /**
     * ข้อมูลบริษัท
     * @return array
     */
    public function getCompanyList()
    {
        $models = OrgCompany::find()
            ->select('id,name')
            ->orderBy('name')
            ->all();
        return ArrayHelper::map($models, 'id', 'name');
    }


    /**
     * ข้อมูลแผนก
     * @return array
     */
    public function getDepartmentList()
    {
        $model = OrgDepartment::find()->orderBy('name')->all();
        return ArrayHelper::map($model, 'id', 'name');
    }

    /**
     * ข้อมูลบุคคลากร
     * @return array
     */
    public function getPersonnelList()
    {
        $model = OrgPersonnel::find()
            ->orderBy('firstname_th')
            ->all();
        return ArrayHelper::map($model, 'user_id', 'fullnameWithCode');
    }

}
