<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bemployee".
 *
 * @property string $EMPID
 * @property string $APPFRM_ID
 * @property string $RCID
 * @property string $DIVID
 * @property string $COMPID
 * @property string $DEPTID
 * @property string $SECID
 * @property string $POSID
 * @property string $SUPERVISOR
 * @property string $JOBDESC
 * @property string $EMP_STATUS
 * @property string $PROBATION
 * @property string $START
 * @property string $ASSIGN
 * @property string $Salary
 * @property string $PREFTH
 * @property string $EMPFNAME
 * @property string $EMPLNAME
 * @property string $TitleEN
 * @property string $FnameEN
 * @property string $LnameEN
 * @property string $Picture
 * @property string $NickName
 * @property string $Blood
 * @property string $BirthDay
 * @property string $Age
 * @property string $Nation
 * @property string $Race
 * @property string $Religion
 * @property string $Height
 * @property string $Weight
 * @property string $Regadd1
 * @property string $Regadd2
 * @property string $Regadd3
 * @property string $Regadd4
 * @property string $Regadd5
 * @property string $Regadd6
 * @property string $Regadd7
 * @property string $Nowadd1
 * @property string $Nowadd2
 * @property string $Nowadd3
 * @property string $Nowadd4
 * @property string $Nowadd5
 * @property string $Nowadd6
 * @property string $Nowadd7
 * @property string $IdcardNo
 * @property string $Prefecture_Card
 * @property string $Province_Card
 * @property string $Expire_Card
 * @property string $House
 * @property string $Marry
 * @property string $Marriage
 * @property string $IncomeSpouse
 * @property string $Mate_Name
 * @property string $Career_Mate
 * @property string $Workadd_Mate
 * @property string $Tel_Mate
 * @property string $Child
 * @property string $FatherName
 * @property string $Father_Career
 * @property string $Father_Age
 * @property string $Father_Life
 * @property string $Mother_Name
 * @property string $Mother_Career
 * @property string $Mother_Age
 * @property string $Mother_Life
 * @property string $Relative
 * @property string $Man
 * @property string $Woman
 * @property string $RelativeLevel
 * @property string $RelateName_1
 * @property string $RelateAge_1
 * @property string $RelatePosition_1
 * @property string $RelateWork_1
 * @property string $RelateTel_1
 * @property string $RelateName_2
 * @property string $RelateAge_2
 * @property string $RelatePosition_2
 * @property string $RelateWork_2
 * @property string $RelateTel_2
 * @property string $RelateName_3
 * @property string $RelateAge_3
 * @property string $RelatePosition_3
 * @property string $RelateWork_3
 * @property string $RelateTel_3
 * @property string $Military
 * @property string $Military_Other
 * @property string $School_1
 * @property string $Major_1
 * @property string $Graduate_1
 * @property string $Grade_1
 * @property string $School_2
 * @property string $Major_2
 * @property string $Graduate_2
 * @property string $Grade_2
 * @property string $School_3
 * @property string $Major_3
 * @property string $Graduate_3
 * @property string $Grade_3
 * @property string $School_4
 * @property string $Major_4
 * @property string $Graduate_4
 * @property string $Grade_4
 * @property string $School_5
 * @property string $Major_5
 * @property string $Graduate_5
 * @property string $Grade_5
 * @property string $School_6
 * @property string $Major_6
 * @property string $Graduate_6
 * @property string $Grade_6
 * @property string $School_7
 * @property string $Major_7
 * @property string $Graduate_7
 * @property string $Grade_7
 * @property string $Activity
 * @property string $SpeakTH
 * @property string $ReadTH
 * @property string $WriteTH
 * @property string $SpeakEN
 * @property string $ReadEN
 * @property string $WriteEN
 * @property string $LanguageOther
 * @property string $SpeakOther
 * @property string $ReadOther
 * @property string $WriteOther
 * @property string $TypeTH
 * @property string $TypeWordTH
 * @property string $TypeEN
 * @property string $TypeWordEN
 * @property string $Fax
 * @property string $Scan
 * @property string $Copier
 * @property string $EquipOther
 * @property string $text_EquipOther
 * @property string $SpecialPrograme
 * @property string $SpecialOther
 * @property string $Motorcye
 * @property string $MotorcyeDriveLicence
 * @property string $Car
 * @property string $CarDriveLicence
 * @property string $Experience
 * @property string $WorkStart_1
 * @property string $WorkEnd_1
 * @property string $Total_1
 * @property string $OldPosition_1
 * @property string $OldSalary_1
 * @property string $OtherIncome_1
 * @property string $OldWorkName_1
 * @property string $OldWorkType_1
 * @property string $OldWorkAdd_1
 * @property string $OldSupervisor_1
 * @property string $OldSuperTel_1
 * @property string $OldDetailJob_1
 * @property string $OldReasonResign_1
 * @property string $WorkStart_2
 * @property string $WorkEnd_2
 * @property string $Total_2
 * @property string $OldPosition_2
 * @property string $OldSalary_2
 * @property string $OtherIncome_2
 * @property string $OldWorkName_2
 * @property string $OldWorkType_2
 * @property string $OldWorkAdd_2
 * @property string $OldSupervisor_2
 * @property string $OldSuperTel_2
 * @property string $OldDetailJob_2
 * @property string $OldReasonResign_2
 * @property string $WorkStart_3
 * @property string $WorkEnd_3
 * @property string $Total_3
 * @property string $OldPosition_3
 * @property string $OldSalary_3
 * @property string $OtherIncome_3
 * @property string $OldWorkName_3
 * @property string $OldWorkType_3
 * @property string $OldWorkAdd_3
 * @property string $OldSupervisor_3
 * @property string $OldSuperTel_3
 * @property string $OldDetailJob_3
 * @property string $OldReasonResign_3
 * @property string $WorkStart_4
 * @property string $WorkEnd_4
 * @property string $Total_4
 * @property string $OldPosition_4
 * @property string $OldSalary_4
 * @property string $OtherIncome_4
 * @property string $OldWorkName_4
 * @property string $OldWorkType_4
 * @property string $OldWorkAdd_4
 * @property string $OldSupervisor_4
 * @property string $OldSuperTel_4
 * @property string $OldDetailJob_4
 * @property string $OldReasonResign_4
 * @property string $WorkStart_5
 * @property string $WorkEnd_5
 * @property string $Total_5
 * @property string $OldPosition_5
 * @property string $OldSalary_5
 * @property string $OtherIncome_5
 * @property string $OldWorkName_5
 * @property string $OldWorkType_5
 * @property string $OldWorkAdd_5
 * @property string $OldSupervisor_5
 * @property string $OldSuperTel_5
 * @property string $OldDetailJob_5
 * @property string $OldReasonResign_5
 * @property string $EmployeeName
 * @property string $EmployeePosition
 * @property string $EmployeeRelation
 * @property string $Penalize
 * @property string $PenalizeNote
 * @property string $Guarantee
 * @property string $OnSite
 * @property string $Disease
 * @property string $DiseaseNote
 * @property string $RecieveNews
 * @property string $EmcName
 * @property string $EmcRelate
 * @property string $EmcAdd
 * @property string $EmcTel
 * @property string $date_register
 * @property string $updateby
 * @property string $lastupdate
 * @property integer $total_vacation
 */
class ScBemployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bemployee';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbSC');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EMPID', 'DEPTID'], 'required'],
            [['START', 'ASSIGN', 'BirthDay', 'date_register', 'lastupdate'], 'safe'],
            [['total_vacation'], 'integer'],
            [['EMPID', 'APPFRM_ID', 'RCID'], 'string', 'max' => 11],
            [['DIVID', 'COMPID', 'DEPTID', 'SECID', 'POSID', 'Regadd5', 'Nowadd5', 'Grade_1', 'Grade_2', 'Grade_3', 'Grade_4', 'Grade_5', 'Grade_6', 'Grade_7'], 'string', 'max' => 5],
            [['SUPERVISOR', 'Salary', 'PREFTH', 'TitleEN', 'Regadd6', 'Regadd7', 'Nowadd6', 'Nowadd7', 'Tel_Mate', 'RelateTel_1', 'RelateTel_2', 'RelateTel_3', 'OldSalary_1', 'OtherIncome_1', 'OldSalary_2', 'OtherIncome_2', 'OldSalary_3', 'OtherIncome_3', 'OldSalary_4', 'OtherIncome_4', 'OldSalary_5', 'OtherIncome_5'], 'string', 'max' => 10],
            [['JOBDESC', 'Picture', 'NickName', 'Nation', 'Race', 'Religion', 'Regadd2', 'Regadd3', 'Regadd4', 'Nowadd2', 'Nowadd3', 'Nowadd4', 'Prefecture_Card', 'Province_Card', 'Military_Other', 'LanguageOther'], 'string', 'max' => 50],
            [['EMP_STATUS', 'Blood', 'Age', 'Child', 'Father_Age', 'Mother_Age', 'Relative', 'Man', 'Woman', 'RelativeLevel', 'RelateAge_1', 'RelateAge_2', 'RelateAge_3', 'TypeTH', 'TypeEN', 'Fax', 'Scan', 'Copier', 'EquipOther', 'Motorcye', 'Car', 'Experience', 'Penalize', 'Guarantee', 'OnSite', 'Disease'], 'string', 'max' => 2],
            [['PROBATION', 'Height', 'Weight', 'House', 'Marry', 'IncomeSpouse', 'Father_Life', 'Mother_Life', 'Military', 'SpeakTH', 'ReadTH', 'WriteTH', 'SpeakEN', 'ReadEN', 'WriteEN', 'SpeakOther', 'ReadOther', 'WriteOther', 'TypeWordTH', 'TypeWordEN'], 'string', 'max' => 3],
            [['EMPFNAME', 'EMPLNAME', 'FnameEN', 'LnameEN', 'Workadd_Mate', 'SpecialPrograme', 'SpecialOther'], 'string', 'max' => 150],
            [['Regadd1', 'Nowadd1', 'Activity', 'OldWorkAdd_1', 'OldDetailJob_1', 'OldWorkAdd_2', 'OldDetailJob_2', 'OldWorkAdd_3', 'OldDetailJob_3', 'OldWorkAdd_4', 'OldDetailJob_4', 'OldWorkAdd_5', 'OldDetailJob_5', 'EmcAdd'], 'string', 'max' => 250],
            [['IdcardNo'], 'string', 'max' => 13],
            [['Expire_Card', 'OldSuperTel_1', 'OldSuperTel_2', 'OldSuperTel_3', 'OldSuperTel_4', 'OldSuperTel_5', 'updateby'], 'string', 'max' => 15],
            [['Marriage', 'MotorcyeDriveLicence', 'CarDriveLicence', 'WorkStart_1', 'WorkEnd_1', 'Total_1', 'WorkStart_2', 'WorkEnd_2', 'Total_2', 'WorkStart_3', 'WorkEnd_3', 'Total_3', 'WorkStart_4', 'WorkEnd_4', 'Total_4', 'WorkStart_5', 'WorkEnd_5', 'Total_5', 'EmcTel'], 'string', 'max' => 20],
            [['Mate_Name', 'Career_Mate', 'FatherName', 'Father_Career', 'Mother_Name', 'Mother_Career', 'RelateName_1', 'RelatePosition_1', 'RelateWork_1', 'RelateName_2', 'RelatePosition_2', 'RelateWork_2', 'RelateName_3', 'RelatePosition_3', 'RelateWork_3', 'School_1', 'Major_1', 'School_2', 'Major_2', 'School_3', 'Major_3', 'School_4', 'Major_4', 'School_5', 'Major_5', 'School_6', 'Major_6', 'School_7', 'Major_7', 'text_EquipOther', 'OldPosition_1', 'OldWorkName_1', 'OldWorkType_1', 'OldSupervisor_1', 'OldReasonResign_1', 'OldPosition_2', 'OldWorkName_2', 'OldWorkType_2', 'OldSupervisor_2', 'OldReasonResign_2', 'OldPosition_3', 'OldWorkName_3', 'OldWorkType_3', 'OldSupervisor_3', 'OldReasonResign_3', 'OldPosition_4', 'OldWorkName_4', 'OldWorkType_4', 'OldSupervisor_4', 'OldReasonResign_4', 'OldPosition_5', 'OldWorkName_5', 'OldWorkType_5', 'OldSupervisor_5', 'OldReasonResign_5', 'EmployeeName', 'EmployeePosition', 'EmployeeRelation', 'PenalizeNote', 'DiseaseNote', 'RecieveNews', 'EmcName', 'EmcRelate'], 'string', 'max' => 100],
            [['Graduate_1', 'Graduate_2', 'Graduate_3', 'Graduate_4', 'Graduate_5', 'Graduate_6', 'Graduate_7'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'EMPID' => 'Empid',
            'APPFRM_ID' => 'Appfrm  ID',
            'RCID' => 'Rcid',
            'DIVID' => 'Divid',
            'COMPID' => 'Compid',
            'DEPTID' => 'Deptid',
            'SECID' => 'Secid',
            'POSID' => 'Posid',
            'SUPERVISOR' => 'Supervisor',
            'JOBDESC' => 'Jobdesc',
            'EMP_STATUS' => 'Emp  Status',
            'PROBATION' => 'Probation',
            'START' => 'Start',
            'ASSIGN' => 'Assign',
            'Salary' => 'Salary',
            'PREFTH' => 'Prefth',
            'EMPFNAME' => 'Empfname',
            'EMPLNAME' => 'Emplname',
            'TitleEN' => 'Title En',
            'FnameEN' => 'Fname En',
            'LnameEN' => 'Lname En',
            'Picture' => 'Picture',
            'NickName' => 'Nick Name',
            'Blood' => 'Blood',
            'BirthDay' => 'Birth Day',
            'Age' => 'Age',
            'Nation' => 'Nation',
            'Race' => 'Race',
            'Religion' => 'Religion',
            'Height' => 'Height',
            'Weight' => 'Weight',
            'Regadd1' => 'Regadd1',
            'Regadd2' => 'Regadd2',
            'Regadd3' => 'Regadd3',
            'Regadd4' => 'Regadd4',
            'Regadd5' => 'Regadd5',
            'Regadd6' => 'Regadd6',
            'Regadd7' => 'Regadd7',
            'Nowadd1' => 'Nowadd1',
            'Nowadd2' => 'Nowadd2',
            'Nowadd3' => 'Nowadd3',
            'Nowadd4' => 'Nowadd4',
            'Nowadd5' => 'Nowadd5',
            'Nowadd6' => 'Nowadd6',
            'Nowadd7' => 'Nowadd7',
            'IdcardNo' => 'Idcard No',
            'Prefecture_Card' => 'Prefecture  Card',
            'Province_Card' => 'Province  Card',
            'Expire_Card' => 'Expire  Card',
            'House' => 'House',
            'Marry' => 'Marry',
            'Marriage' => 'Marriage',
            'IncomeSpouse' => 'Income Spouse',
            'Mate_Name' => 'Mate  Name',
            'Career_Mate' => 'Career  Mate',
            'Workadd_Mate' => 'Workadd  Mate',
            'Tel_Mate' => 'Tel  Mate',
            'Child' => 'Child',
            'FatherName' => 'Father Name',
            'Father_Career' => 'Father  Career',
            'Father_Age' => 'Father  Age',
            'Father_Life' => 'Father  Life',
            'Mother_Name' => 'Mother  Name',
            'Mother_Career' => 'Mother  Career',
            'Mother_Age' => 'Mother  Age',
            'Mother_Life' => 'Mother  Life',
            'Relative' => 'Relative',
            'Man' => 'Man',
            'Woman' => 'Woman',
            'RelativeLevel' => 'Relative Level',
            'RelateName_1' => 'Relate Name 1',
            'RelateAge_1' => 'Relate Age 1',
            'RelatePosition_1' => 'Relate Position 1',
            'RelateWork_1' => 'Relate Work 1',
            'RelateTel_1' => 'Relate Tel 1',
            'RelateName_2' => 'Relate Name 2',
            'RelateAge_2' => 'Relate Age 2',
            'RelatePosition_2' => 'Relate Position 2',
            'RelateWork_2' => 'Relate Work 2',
            'RelateTel_2' => 'Relate Tel 2',
            'RelateName_3' => 'Relate Name 3',
            'RelateAge_3' => 'Relate Age 3',
            'RelatePosition_3' => 'Relate Position 3',
            'RelateWork_3' => 'Relate Work 3',
            'RelateTel_3' => 'Relate Tel 3',
            'Military' => 'Military',
            'Military_Other' => 'Military  Other',
            'School_1' => 'School 1',
            'Major_1' => 'Major 1',
            'Graduate_1' => 'Graduate 1',
            'Grade_1' => 'Grade 1',
            'School_2' => 'School 2',
            'Major_2' => 'Major 2',
            'Graduate_2' => 'Graduate 2',
            'Grade_2' => 'Grade 2',
            'School_3' => 'School 3',
            'Major_3' => 'Major 3',
            'Graduate_3' => 'Graduate 3',
            'Grade_3' => 'Grade 3',
            'School_4' => 'School 4',
            'Major_4' => 'Major 4',
            'Graduate_4' => 'Graduate 4',
            'Grade_4' => 'Grade 4',
            'School_5' => 'School 5',
            'Major_5' => 'Major 5',
            'Graduate_5' => 'Graduate 5',
            'Grade_5' => 'Grade 5',
            'School_6' => 'School 6',
            'Major_6' => 'Major 6',
            'Graduate_6' => 'Graduate 6',
            'Grade_6' => 'Grade 6',
            'School_7' => 'School 7',
            'Major_7' => 'Major 7',
            'Graduate_7' => 'Graduate 7',
            'Grade_7' => 'Grade 7',
            'Activity' => 'Activity',
            'SpeakTH' => 'Speak Th',
            'ReadTH' => 'Read Th',
            'WriteTH' => 'Write Th',
            'SpeakEN' => 'Speak En',
            'ReadEN' => 'Read En',
            'WriteEN' => 'Write En',
            'LanguageOther' => 'Language Other',
            'SpeakOther' => 'Speak Other',
            'ReadOther' => 'Read Other',
            'WriteOther' => 'Write Other',
            'TypeTH' => 'Type Th',
            'TypeWordTH' => 'Type Word Th',
            'TypeEN' => 'Type En',
            'TypeWordEN' => 'Type Word En',
            'Fax' => 'Fax',
            'Scan' => 'Scan',
            'Copier' => 'Copier',
            'EquipOther' => 'Equip Other',
            'text_EquipOther' => 'Text  Equip Other',
            'SpecialPrograme' => 'Special Programe',
            'SpecialOther' => 'Special Other',
            'Motorcye' => 'Motorcye',
            'MotorcyeDriveLicence' => 'Motorcye Drive Licence',
            'Car' => 'Car',
            'CarDriveLicence' => 'Car Drive Licence',
            'Experience' => 'Experience',
            'WorkStart_1' => 'Work Start 1',
            'WorkEnd_1' => 'Work End 1',
            'Total_1' => 'Total 1',
            'OldPosition_1' => 'Old Position 1',
            'OldSalary_1' => 'Old Salary 1',
            'OtherIncome_1' => 'Other Income 1',
            'OldWorkName_1' => 'Old Work Name 1',
            'OldWorkType_1' => 'Old Work Type 1',
            'OldWorkAdd_1' => 'Old Work Add 1',
            'OldSupervisor_1' => 'Old Supervisor 1',
            'OldSuperTel_1' => 'Old Super Tel 1',
            'OldDetailJob_1' => 'Old Detail Job 1',
            'OldReasonResign_1' => 'Old Reason Resign 1',
            'WorkStart_2' => 'Work Start 2',
            'WorkEnd_2' => 'Work End 2',
            'Total_2' => 'Total 2',
            'OldPosition_2' => 'Old Position 2',
            'OldSalary_2' => 'Old Salary 2',
            'OtherIncome_2' => 'Other Income 2',
            'OldWorkName_2' => 'Old Work Name 2',
            'OldWorkType_2' => 'Old Work Type 2',
            'OldWorkAdd_2' => 'Old Work Add 2',
            'OldSupervisor_2' => 'Old Supervisor 2',
            'OldSuperTel_2' => 'Old Super Tel 2',
            'OldDetailJob_2' => 'Old Detail Job 2',
            'OldReasonResign_2' => 'Old Reason Resign 2',
            'WorkStart_3' => 'Work Start 3',
            'WorkEnd_3' => 'Work End 3',
            'Total_3' => 'Total 3',
            'OldPosition_3' => 'Old Position 3',
            'OldSalary_3' => 'Old Salary 3',
            'OtherIncome_3' => 'Other Income 3',
            'OldWorkName_3' => 'Old Work Name 3',
            'OldWorkType_3' => 'Old Work Type 3',
            'OldWorkAdd_3' => 'Old Work Add 3',
            'OldSupervisor_3' => 'Old Supervisor 3',
            'OldSuperTel_3' => 'Old Super Tel 3',
            'OldDetailJob_3' => 'Old Detail Job 3',
            'OldReasonResign_3' => 'Old Reason Resign 3',
            'WorkStart_4' => 'Work Start 4',
            'WorkEnd_4' => 'Work End 4',
            'Total_4' => 'Total 4',
            'OldPosition_4' => 'Old Position 4',
            'OldSalary_4' => 'Old Salary 4',
            'OtherIncome_4' => 'Other Income 4',
            'OldWorkName_4' => 'Old Work Name 4',
            'OldWorkType_4' => 'Old Work Type 4',
            'OldWorkAdd_4' => 'Old Work Add 4',
            'OldSupervisor_4' => 'Old Supervisor 4',
            'OldSuperTel_4' => 'Old Super Tel 4',
            'OldDetailJob_4' => 'Old Detail Job 4',
            'OldReasonResign_4' => 'Old Reason Resign 4',
            'WorkStart_5' => 'Work Start 5',
            'WorkEnd_5' => 'Work End 5',
            'Total_5' => 'Total 5',
            'OldPosition_5' => 'Old Position 5',
            'OldSalary_5' => 'Old Salary 5',
            'OtherIncome_5' => 'Other Income 5',
            'OldWorkName_5' => 'Old Work Name 5',
            'OldWorkType_5' => 'Old Work Type 5',
            'OldWorkAdd_5' => 'Old Work Add 5',
            'OldSupervisor_5' => 'Old Supervisor 5',
            'OldSuperTel_5' => 'Old Super Tel 5',
            'OldDetailJob_5' => 'Old Detail Job 5',
            'OldReasonResign_5' => 'Old Reason Resign 5',
            'EmployeeName' => 'Employee Name',
            'EmployeePosition' => 'Employee Position',
            'EmployeeRelation' => 'Employee Relation',
            'Penalize' => 'Penalize',
            'PenalizeNote' => 'Penalize Note',
            'Guarantee' => 'Guarantee',
            'OnSite' => 'On Site',
            'Disease' => 'Disease',
            'DiseaseNote' => 'Disease Note',
            'RecieveNews' => 'Recieve News',
            'EmcName' => 'Emc Name',
            'EmcRelate' => 'Emc Relate',
            'EmcAdd' => 'Emc Add',
            'EmcTel' => 'Emc Tel',
            'date_register' => 'Date Register',
            'updateby' => 'Updateby',
            'lastupdate' => 'Lastupdate',
            'total_vacation' => 'Total Vacation',
        ];
    }
}
