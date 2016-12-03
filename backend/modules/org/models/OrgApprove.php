<?php

namespace backend\modules\org\models;

use Yii;
use common\models\SysDocumentOption;


/**
 * This is the model class for table "org_structure_item".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $user_code
 * @property integer $parent_id
 * @property string $first_name
 * @property integer $hide
 * @property integer $position_id
 * @property integer $level
 * @property integer $create_at
 * @property integer $create_by
 */
class OrgApprove extends OrgStructureItem
{


    //Type of approve
    const TYPE_REQUEST = 'REQUEST';
    const  TYPE_APPROVER = 'APPROVER';


    //Status approve
    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const  STATUS_DISAPPROVED = 'DISAPPROVED';


    /**
     * การหาลำดับอนุมัติ หาได้  4 แบบ
     * 1.หาตามองค์กร
     * 2.หาตามตำแหน่ง
     * 3.หาแบบกำหนดเอง
     * 4.หาแบบผสม
     *
     *********** type_ask
     * Approval  = ใบขออนุมัติ
     * approve = การอนุมัติ
     * @param array $option
     * @param string $type_ask
     * @return array
     */
    public function getListApprove($option = array(), $type_ask = 'Approval')
    {
        //หารายชื่อผู้ที่จะอนุมัติ
        $data_approve = self::geDataApprove($option);

        $config = [
            'document_id' => $option['document_id'],
            //  'type_ask' => self::TYPE_APPROVER,
            'site_id' => $option['site_id'],
            'company_id' => $option['company_id'],
            'table_name' => $option['table_name'],
            'ref_id' => $option['ref_id'],
            'table_main' => $option['table_main'],
            // '_type' => $option['_type'],
        ];

        //รายชื่อผู้อนุมัติไปแล้วทั้งหมด
        $listApproved = self::getDataApproved($option);

        $data = []; // ตัวแปรเก็บการอนุมัติ
        $seqApproved = 1;

        //รายชื่อผู้ที่อนุมัติไปแล้ว
        if (count($listApproved) > 0) {
            foreach ($listApproved as $key => $val_xx) {
                if (isset($data_approve[$key])) {
                    unset($data_approve[$key]);
                }
                $data[$seqApproved] = $val_xx;
                $data[$seqApproved]['user_id'] = $key;
                $person = OrgPersonnel::findOne(['user_id' => $key]);
                $data[$seqApproved]['fullname'] = $person->fullnameTH;
                $seqApproved++;
            }
        }

        //รายชื่อผู้ที่จะอนุมัติ
        if (count($data_approve) > 0) {
            foreach ($data_approve as $key_a => $val_d) {
                $person = OrgPersonnel::findOne(['user_id' => $key_a]);
                $data[$seqApproved] = $val_d;
                $data[$seqApproved]['user_id'] = $key_a;
                $data[$seqApproved]['position'] = implode(",", $val_d['position']);
                $data[$seqApproved]['fullname'] = $person->fullnameTH;
                $data[$seqApproved]['approve_date'] = '';
                $seqApproved++;
            }
        }
        return $data;
    }

    /**
     * ค้นหารายชื่อผุ้ที่จะทำการอนุมัติ
     * @param array $option
     * @param $type_ask
     * @return array
     */
    public function geDataApprove($option = array())
    {
        /*ข้อมูลรูปแบบการอนุมัติที่ได้กำหนดไว้ เช่น
         * อนุมัติตามที่กำหนด, อนุมัติตามตำแหน่ง, อนุมัติตามแผนผังองค์กร
         *
         */
        $rows = SysDocumentOption::find()
            ->where([
                'company_id' => $option['company_id'],
                'document_id' => $option['document_id'],
                'site_id' => $option['site_id'],
                'active' => SysDocumentOption::STATUS_ACTIVE,
            ])
            ->all();

        $approvers = []; // เก็บข้อมูลรายชื่อผู้ที่จะอนุมัติ
        foreach ($rows as $row):
            //อนุมัติแบบกำหนดเอง
            if ($row->_type == SysDocumentOption::TYPE_CUSTOM) {
                $dataCustom = self::findByCustom(unserialize($row->data), $row->seq, $option);
                if (count($dataCustom > 0))
                    $approvers[] = $dataCustom;

            } //อนุมัติแบบตามตำแหน่ง
            elseif ($row->_type == SysDocumentOption::TYPE_POSITION) {
                $dataPos = self::findByPosition(unserialize($row->data), $row->seq, $option);
                if (count($dataPos > 0))
                    $approvers[] = $dataPos;

            } //อนุมัติตามแผนผังองค์กร
            elseif ($row->_type == SysDocumentOption::TYPE_ORGANIZATION) {
                $dataOrg = self::findByOrganization(unserialize($row->data), $row->seq, $option);
                if (count($dataOrg) > 0)
                    $approvers[] = $dataOrg;

            }
        endforeach;

        //คัดกรอกรายชื่อที่ซ้ำออก
        $lists = self::duplicate_user($approvers);
        $users = [];
        $i = 1;
        foreach ($lists as $list) {
            foreach ($list as $key => $val) {
                $users[$key] = $val;
                $i++;
            }
        }
        return $users;
    }

    /**
     * รายชื่อผู้อนุมัติแล้ว
     * @param $option
     * @return array
     */
    public function getDataApproved($option)
    {
        $table_main = $option['table_main'];
        $table_name = $option['table_name'];
        $ref_id = $option['ref_id'];
        $arr = [];
        $sqlGet = " SELECT 
            user_id, user_code,seq,position_name,app_status,created_at
            FROM {$table_main}
			WHERE table_name='$table_name' 
			AND ref_id ='$ref_id'
			ORDER BY seq  ";
        $sqlquery = Yii::$app->db->createCommand($sqlGet, [
            'company_id' => $option['company_id'],
            'document_id' => $option['document_id'],
            'site_id' => $option['site_id']
        ])
            ->query();

        foreach ($sqlquery as $row) {
            $arr[$row['user_id']]['position'] = $row['position_name'];
            $arr[$row['user_id']]['active'] = 1;
            $arr[$row['user_id']]['user_code'] = $row['user_code'];
            $arr[$row['user_id']]['approve_date'] = Yii::$app->formatter->asDate($row['created_at'], 'medium');
        }
        return $arr;
    }

    /**
     *  ลบ array ที่มีผู้อนุมัติ เป็น 0
     * @param array $listApprover
     * @return array
     */
    public function duplicate_user($listApprover = array())
    {
        if (count($listApprover) == 3) {
            foreach ($listApprover[1] as $key1 => $val1) {
                if (isset($listApprover[0][$key1])) {
                    unset($listApprover[0][$key1]);
                }
            }
            foreach ($listApprover[2] as $key1 => $val1) {
                if (isset($listApprover[0][$key1])) {
                    unset($listApprover[0][$key1]);
                }
                if (isset($listApprover[1][$key1])) {
                    unset($listApprover[1][$key1]);
                }
            }
        } elseif (count($listApprover) == 2) {
            foreach ($listApprover[1] as $key1 => $val1) {
                if (isset($listApprover[0][$key1])) {
                    unset($listApprover[0][$key1]);
                }
            }
        }

        /*
         * ลบ array ที่มีผู้อนุมัติ เป็น 0
         */
        if (count($listApprover) != 1) {
            $num3 = count($listApprover) - 1;
            for ($num3; $num3 >= 0; $num3--) {
                if (count($listApprover[$num3]) == 0) {
                    unset($listApprover[$num3]);
                }
            }
        }
        return $listApprover;
    }

    /**
     * หารายชื่อผูจะอนุมัติตามที่กำหนดไว้
     * @param $settings
     * @param $seq
     * @param $option
     * @return array
     */
    public function findByCustom($settings, $seq, $option)
    {
        $users = [];
        if ($seq == 1) {
            $person = OrgPersonnel::findOne(['user_id' => $option['user_id']]);
            $users[$option['user_id']] = $option['user_id'];
            $users[$option['user_id']]['fullname'] = $person->fullnameTH;
        }

        if (count($settings) > 0) {
            //$arr_user=[];
            foreach ($settings as $index => $val) {
                $person = OrgPersonnel::findOne(['user_id' => $index]);
                $users[$index] = $val;
                $users[$index]['active'] = 0;
                // $arr_user[$c_key]=$c_key;
                $users[$index]['fullname'] = $person->fullnameTH;
            }
        }
        return $users;
    }

    /**
     * หารายชื่อผู้จะอนุมัติตามแผนผังองค์กร
     * @param $data
     * @param $seq
     * @param $option
     * @return array
     */
    public function findByOrganization($data, $seq, $option)
    {
        /*
        echo'<pre>';
        print_r($option);
        echo'<pre>';
        */
        $user_id = $option['approver_user_id'];
        $arr_doc = array();
        if ($user_id != '') {
            $sqlGet = " SELECT zz.*,op.name_th,op.`level` 
               FROM (
					SELECT osi.id, osu.site_id,osi.position_id,osi.user_code,osi.company_id,osi.user_id FROM org_structure_item osi
					INNER JOIN org_site_user osu on osi.user_id=osu.user_id
					WHERE 1
					AND osi.user_id=:user_id
					AND osu.site_id=:site_id 
					AND company_id=:company_id
					GROUP BY osi.position_id
				) zz
				INNER JOIN org_position op on op.id=zz.position_id
				ORDER BY op.`level`*1   ";

            $rows = Yii::$app->db->createCommand($sqlGet, [
                'user_id' => $user_id,
                'company_id' => $option['company_id'],
                'site_id' => $option['site_id']
            ])->queryOne();

            $user_key = $rows['id'];
            $company_id = $rows['company_id'];
            $sqlGetuser = "SELECT   T2.user_id, T2.user_code ,p.name_th,p.`level` ,T2.position_id
	    	FROM (
	    	SELECT @r AS m_id,h.position_id,h.company_id,
	    	(SELECT @r :=parent_id FROM org_structure_item WHERE id = m_id) AS parent_id,
	    	@l := @l + 1 AS lvl
	    	FROM
	    	(SELECT @r := '$user_key', @l := 0) vars,
	    	org_structure_item h
	    	WHERE @r <> 0 AND h.company_id='$company_id'
	    	)  T1
	    	JOIN org_structure_item T2 ON T1.m_id = T2.id
	    	INNER JOIN org_position p on p.id=T2.position_id
	    	ORDER BY T1.lvl asc ,`level` desc ";
            $sqlquery = Yii::$app->db->createCommand($sqlGetuser)->query();
            $level = $data['level']; // ระดับทีกำหนดไว้ในระบบ
            foreach ($sqlquery as $row) {

                if ($row['user_id'] != '') {
                    //ถ้าผู้อนุมัติ มีระดับมากกว่าหรือเท่ากับที่กำหนดไว้ในระบบ และมีค่าระดับไม่เป็นค่าว่าง
                    if ($row['level'] >= $level && $level != '') {
                        $person = OrgPersonnel::findOne(['user_id' => $row['user_id']]);
                        $arr_doc[$row['user_id']]['user_id'] = $person->user_id;
                        $arr_doc[$row['user_id']]['user_code'] = $person->code;
                        $arr_doc[$row['user_id']]['fullname'] = $person->fullnameTH;
                        $arr_doc[$row['user_id']]['position'][$row['position_id']] = $row['name_th'];
                        $arr_doc[$row['user_id']]['active'] = 0;
                        $arr_doc[$row['user_id']]['position_level'] = $row['level'];
                    }

                    //ถ้าระดับของผู้อนุมัติมีค่าว่าง
                    if ($level == '') {
                        $person = OrgPersonnel::findOne(['user_id' => $row['user_id']]);
                        $arr_doc[$row['user_id']]['user_id'] = $person->user_id;
                        $arr_doc[$row['user_id']]['user_code'] = $person->code;
                        $arr_doc[$row['user_id']]['fullname'] = $person->fullnameTH;
                        $arr_doc[$row['user_id']]['position'][$row['position_id']] = $row['name_th'];
                        $arr_doc[$row['user_id']]['active'] = 0;
                        $arr_doc[$row['user_id']]['position_level'] = $row['level'];

                    }
                }
            }
        }
        return $arr_doc;
    }


    /**
     * หารายชื่อผู้จะอนุมัติตามตำแหน่ง
     * @param $data
     * @param $seq
     * @param $option
     * @return array
     */
    public function findByPosition($data, $seq, $option)
    {
        $position = implode("','", $data);
        $arr_doc = array();
        $sqlPosition = "SELECT osi.id,osi.user_id,osi.user_code,osi.parent_id,
                osi.first_name,osi.position_id ,osu.site_id,op.name_th,op.`level`
				FROM org_structure_item osi
				INNER JOIN org_site_user osu on osi.user_id=osu.user_id
				INNER JOIN org_position op on op.id=osi.position_id
				WHERE  osu.site_id='3' AND osi.position_id in('$position')
				ORDER BY op.`level` desc ";
        $sqlPos = Yii::$app->db->createCommand($sqlPosition)->query();

        if ($seq == 1) {
            $arr_doc[$option['user_id']] = $option['user_id'];//ดึงข้อมูลมาจาก$_SESSION['user_code']
        }
        foreach ($sqlPos as $row) {
            $person = OrgPersonnel::findOne(['user_id' => $row['user_id']]);
            $arr_doc[$row['user_id']]['user_id'] = $person->user_id;
            $arr_doc[$row['user_id']]['user_code'] = $person->code;
            $arr_doc[$row['user_id']]['fullname'] = $person->fullnameTH;
            $arr_doc[$row['user_id']]['position'][$row['position_id']] = $row['name_th'];
            $arr_doc[$row['user_id']]['active'] = 0;
            $arr_doc[$row['user_id']]['position_level'] = $row['level'];
        }
        return $arr_doc;
    }
}
