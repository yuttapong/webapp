<?php

namespace backend\modules\purchase\models;

use backend\modules\org\models\OrgPersonnel;
use Yii;

/**
 * This is the model class for table "org_personnel".
 *
 * @property string $id
 * @property string $user_id
 * @property string $code
 * @property integer $prefix_id
 * @property string $prefix_name_th
 * @property string $firstname_th
 * @property string $lastname_th
 * @property string $nickname
 * @property string $prefix_name_en
 * @property string $firstname_en
 * @property string $lastname_en
 * @property string $middlename_th
 * @property string $middlename_en
 * @property string $birthday
 * @property integer $day_probation
 * @property string $work_status
 * @property string $work_type
 * @property string $military_status
 * @property integer $status
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
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $active
 * @property string $photo
 * @property double $weight
 * @property double $height
 * @property string $start_working
 */
class Personnel extends OrgPersonnel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_personnel';
    }



    public function getFullnameTH()
    {
        return @$this->firstname_th . ' ' . $this->lastname_th;
    }
}
