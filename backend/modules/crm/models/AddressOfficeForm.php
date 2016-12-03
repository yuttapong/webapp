<?php
namespace backend\modules\crm\models;
use common\models\GeneralAddress;
use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;
/**
 * Address Office form
 */
class AddressOfficeForm extends Model
{
    public  $id;
    public $company;
    public $province_id;
    public $amphur_id;


    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company'],'string'],
            [['id','province_id', 'amphur_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company' => 'ชื่อบริษัท',
            'province_id' => 'จังหวัด',
            'amphur_id' => 'เขต/อำเภอ',
        ];
    }

    public function saveAddress($modelCustomer){
        $model = new GeneralAddress();
       // $model->scenario = GeneralAddress::TYPE_OFFICE;
        $model->type = GeneralAddress::TYPE_OFFICE;
        $model->company = $this->company;
        $model->province_id = $this->province_id;
        $model->amphur_id = $this->amphur_id;
        $model->table_name = Customer::TABLE_NAME;
        $model->table_key = $modelCustomer->id;
        $model->save();
        print_r($model->errors);
    }
}
