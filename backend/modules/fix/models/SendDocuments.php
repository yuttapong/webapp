<?php

namespace backend\modules\fix\models;

use Yii;
use backend\modules\org\models\OrgPersonnel;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Html;
use common\models\User;

/**
 * This is the model class for table "fix_send_documents".
 *
 * @property integer $id
 * @property string $table_name
 * @property integer $table_key
 * @property string $title
 * @property integer $send_user_id
 * @property integer $send_at
 * @property integer $recipient_user_id
 * @property integer $recipient_at
 * @property string $option
 * @property integer $is_khow
 */
class SendDocuments extends \yii\db\ActiveRecord
{

    //สถานะการรับทราบ
    const  STATUS_NEW = 0;
    const  STATUS_DONE = 1;
    const  STATUS_NOT_DONE = 2;
	public  $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_send_documents';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->send_at = time();
                $this->send_user_id = Yii::$app->user->id;
                $this->send_user_name = $this->getPersonnelName(Yii::$app->user->id);
            } else {

            }
            return true;
        } else {

            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_key'], 'required'],
            [['table_key', 'send_user_id', 'send_at', 'recipient_user_id', 'recipient_at', 'is_khow'], 'integer'],
            [['option'], 'string'],
            [['table_name'], 'string', 'max' => 50],
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
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'title' => 'เรื่อง',
            'send_user_id' => 'Send User ID',
            'send_at' => 'Send At',
            'recipient_user_id' => 'Recipient User ID',
            'recipient_at' => 'Recipient At',
            'option' => 'Option',
            'is_khow' => 'สถานะรับทราบ',
            'send_user_name' => 'ผู้ส่ง',
            'project_id' => 'โครงการ',
            'isKnowText' => 'สถานะรับทราบ',
        ];
    }

    public function getPersonnelName($user_id)
    {
        $model = OrgPersonnel::findOne(['user_id' => $user_id]);
        return $model->prefix_name_th . ' ' . $model->firstname_th . ' ' . $model->lastname_th;
    }

    public function getListOption()
    {
        $option = unserialize($this->option);
        $text_khow = '';
        if ($this->table_name == 'fix_inform_fix') {
            if (!empty($option['home_no'])) {

                $text_khow .= Html::a('<strong>เลขที่</strong> ' . $option['code'], Url::to(['/fix/inform-fix/view', 'id' => $option['id']]));
            }
            if (!empty($option['project_name'])) {
                $text_khow .= ' ' . $option['project_name'];
            }

            if (!empty($option['home_no'])) {
                if ($text_khow != '') {
                    $text_khow .= '<br>';
                }
                $text_khow .= '<strong>แปลง</strong> ' . $option['home_no'];
            }


            if (!empty($option['customer'])) {
                if ($text_khow != '') {
                    $text_khow .= '<br>';
                }
                $text_khow .= '<strong>ลูกค้า </strong> ' . $option['customer'];
            }
        }

        return $text_khow;

    }

    public function getDetailOption()
    {
        $text_khow = '';
        $option = unserialize($this->option);
        if ($this->table_name == 'fix_inform_fix') {
            if (!empty($option['job_name'])) {
                if ($text_khow != '') {
                    $text_khow .= '<br><strong>แจ้งเรื่อง</strong> <br>';
                }
                $text_khow .= $option['job_name'];
            }
        }
        return $text_khow;
    }


    public function getIsKnowText()
    {
        return ArrayHelper::getValue(self::getIsKnowItems(),$this->is_khow);
    }

    public function getIsKnowItems(){
        return [
            self::STATUS_NEW=> 'เอกสารใหม่',
            self::STATUS_DONE=> 'รับทราบแล้ว',
            self::STATUS_NOT_DONE => 'เสนอเนะ',
        ];
    }
    public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'recipient_user_id']);
    }


}
