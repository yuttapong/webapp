<?php

namespace backend\modules\crm\models;

use backend\modules\org\models\OrgPersonnel;
use common\models\GeneralAddress;
use common\models\SysAmphur;
use common\models\SysTambon;
use  common\models\SysProvince;
use yii\helpers\ArrayHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "crm_customer".
 *
 * @property string $id
 * @property string $prefixname
 * @property string $firstname
 * @property string $lastname
 * @property string $birthday
 * @property string $mobile
 * @property integer $age
 * @property string $email
 * @property string $tel
 */
class Customer extends \yii\db\ActiveRecord
{

    const  TABLE_NAME = 'crm_customer';

    //สถานะ
    const  STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;

    //แหล่งที่มาของลูกค้า
    const SOURCE_WEBSITE = 'WEBSITE';
    const SOURCE_FACEBOOK = 'FACEBOOK';
    const SOURCE_CALL_IN = 'CALL_IN';
    const SOURCE_EVENT = 'EVENT';
    const  SOURCE_WALK_IN = 'WALK_IN';
    const  SOURCE_BILLBOARDS = 'BILLBOARDS';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crm_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'prefixname', 'gender', 'active'], 'required'],
            [['id', 'age', 'created_at', 'created_by', 'updated_at', 'updated_by', 'active', 'is_vip'], 'integer'],
            [['birthday', 'day_visit'], 'safe'],
            [['prefixname', 'mobile', 'tel', 'gender', 'source', 'prefixname_other'], 'string', 'max' => 20],
            [['firstname', 'lastname'], 'string', 'max' => 45],
            ['email', 'email'],
            [['email', 'firstname', 'lastname'], 'filter', 'filter' => 'trim'],
            ['email', 'unique', 'message' => 'อีเมล์นี้มีแล้วในระบบ.'],
            [['firstname', 'lastname'], 'unique', 'targetAttribute' => ['firstname', 'lastname'], 'message' => 'ชื่อและนามสกุล มีแล้วในระบบ อย่าบันทึกข้อมูลซ้ำอีก']
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
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prefixname' => 'คำนำหน้า',
            'firstname' => 'ชื่อ',
            'lastname' => 'นามสกุล',
            'birthday' => 'วันเกิด',
            'mobile' => 'มือถือ',
            'age' => 'อายุ',
            'email' => 'Email',
            'tel' => 'เบอร์โทรบ้าน',
            'gender' => 'เพศ',
            'created_at' => Yii::t('crm', 'บันทึกเมื่อ'),
            'created_by' => Yii::t('crm', 'บันทึกโดย'),
            'updated_at' => Yii::t('crm', 'แก้ไขล่าสุด'),
            'updated_by' => Yii::t('crm', 'แก้ไขโดย'),
            'fullname' => 'ชื่อ-สกุล',
            'genderName' => 'เพศ',
            'status' => 'สถานะ',
            'active' => 'สถานะ',
            'source' => 'ทราบโครงการจากสื่อ',
            'is_vip' => 'ลูกค้า VIP ? ',
            'prefixname_other' => 'คำนำหน้าพิเศษ',
            'day_visit' => 'เยี่ยมชมโครงการเมื่อ',
            'createdName' => 'บันทึกโดย',
            'updatedName' =>'แก้ไขล่าสุดโดย'
        ];
    }


    public function attributeHints()
    {
        return [
            'prefixname_other' => 'เช่น  ดร.  นพ.  ม.ร.ว. ',
            // 'mobile' => 'ไม่ต้องใส่ขีด เช่น 0812345678',
            // 'tel' => 'ไม่ต้องใส่ขีด เช่น 022151111',
            'birthday' => 'รูปแบบ พ.ศ. เช่น 31-12-2530',
        ];
    }


    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }

    /**
     * ข้อมูลแบบสอบถามที่ลูกค้ากรอก
     * @return $this
     */
    public function getQuestionnaires()
    {
        return $this->hasMany(Response::className(), [
            'table_key' => 'id',
        ])->orderBy(['created_at' => SORT_DESC]);
    }


    /**
     * ข้อมูลการติดต่อสือสาร
     * @return $this
     */
    public function getCommunications()
    {
        return $this->hasMany(Communication::className(), [
            'customer_id' => 'id',
        ])->orderBy(['created_at' => SORT_DESC]);
    }


    public function getFullname()
    {
        return @$this->firstname . ' ' . $this->lastname;
    }

    /**
     * Address
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(GeneralAddress::className(), [
            'table_key' => 'id'
        ]);
    }

    /**
     * @return mixed
     */
    public function getProvinceItems()
    {
        $model = SysProvince::find()
            ->orderBy(['name_th' => SORT_ASC])
            ->all();
        return ArrayHelper::map($model, 'id', 'name_th');
    }

    public static function getGenderItems()
    {
        return [
            'M' => 'ชาย',
            'F' => 'หญิง'
        ];
    }

    public function getGenderName()
    {
        return ArrayHelper::getValue(self::getGenderItems(), $this->gender);
    }

    public static function getStatusItems()
    {
        return [
            self::STATUS_INACTIVE => 'No',
            self::STATUS_ACTIVE => 'Yes'
        ];
    }

    public static function getSourceItems()
    {
        return [
            self::SOURCE_WEBSITE => 'เว็บไซต์',
            self::SOURCE_FACEBOOK => 'Facebook',
            self::SOURCE_CALL_IN => 'Call In',
            self::SOURCE_EVENT => 'งาน Event',
            self::SOURCE_WALK_IN => 'Walk In',
            self::SOURCE_BILLBOARDS => 'ป้ายโฆษณา',

        ];
    }

    public function getSourceName()
    {
        return ArrayHelper::getValue($this->sourceItems, $this->source);
    }

    public static function getPrefixNameItems()
    {
        return [
            'นาย' => 'นาย',
            'นาง' => 'นาง',
            'นางสาว' => 'นางสาว',
        ];
    }

    public function getPrefixName()
    {
        return ArrayHelper::getValue($this->prefixNameItems, $this->prefixname);
    }

    public function getOrgPersonnel()
    {
        return $this->hasOne(OrgPersonnel::className(), ['user_id' => 'created_by']);
    }

    public function getPersonsInCharge()
    {
        return $this->hasOne(CustomerResponsible::className(), ['customer_id' => 'id']);
    }


    private function _findUser($id)
    {
        $user = OrgPersonnel::find()->where(['user_id'=>$this->created_by])->one();
        if($user)
            return $user;
    }

    public function getCreatedName(){
        $user = self::_findUser($this->created_by);
        return @$user->firstname_th;
    }

    public function getUpdatedName(){
        $user = self::_findUser($this->updated_by);
        return @$user->firstname_th;
    }



    // ค้นหา ผุ้ครับผิดชอบคนล่าสุด
    private function _findCurrentPersonInCharge(){
        $user = CustomerResponsible::find()
            ->where(['customer_id'=> $this->id])
            ->orderBy(['created_at'=>SORT_DESC])
            ->limit(1)
            ->one();
        if($user)
            return $user;

    }

    // ผุ้ครับผิดชอบคนล่าสุด
    public function getCurrentPersonInCharge(){
        $user = $this->_findCurrentPersonInCharge();
        return  @$user->personnel->firstname_th;
    }

    // ผุ้ครับผิดชอบคนล่าสุด ชื่อแบบเต็ม
    public function getCurrentPersonInChargeFullname(){
        $user = $this->_findCurrentPersonInCharge();
        return  @$user->personnel->fullnameTH;
    }


    // จำนวนแบบสอบถามของลูกค้า
    public function getCountQuestionnaire() {
        $questionnaire = Response::find()
            ->where(['customer_id'=>$this->id, 'active' => Response::STATUS_ACTIVE])
            ->count();
        return $questionnaire;
    }

}
