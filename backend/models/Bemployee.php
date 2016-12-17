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
class Bemployee extends \yii\db\ActiveRecord
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
     * @return bemployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BemployeeQuery(get_called_class());
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
            'EMPID' => Yii::t('app', 'Empid'),
            'APPFRM_ID' => Yii::t('app', 'Appfrm  ID'),
            'RCID' => Yii::t('app', 'Rcid'),
            'DIVID' => Yii::t('app', 'Divid'),
            'COMPID' => Yii::t('app', 'Compid'),
            'DEPTID' => Yii::t('app', 'Deptid'),
            'SECID' => Yii::t('app', 'Secid'),
            'POSID' => Yii::t('app', 'Posid'),
            'SUPERVISOR' => Yii::t('app', 'Supervisor'),
            'JOBDESC' => Yii::t('app', 'Jobdesc'),
            'EMP_STATUS' => Yii::t('app', 'Emp  Status'),
            'PROBATION' => Yii::t('app', 'Probation'),
            'START' => Yii::t('app', 'Start'),
            'ASSIGN' => Yii::t('app', 'Assign'),
            'Salary' => Yii::t('app', 'Salary'),
            'PREFTH' => Yii::t('app', 'Prefth'),
            'EMPFNAME' => Yii::t('app', 'Empfname'),
            'EMPLNAME' => Yii::t('app', 'Emplname'),
            'TitleEN' => Yii::t('app', 'Title En'),
            'FnameEN' => Yii::t('app', 'Fname En'),
            'LnameEN' => Yii::t('app', 'Lname En'),
            'Picture' => Yii::t('app', 'Picture'),
            'NickName' => Yii::t('app', 'Nick Name'),
            'Blood' => Yii::t('app', 'Blood'),
            'BirthDay' => Yii::t('app', 'Birth Day'),
            'Age' => Yii::t('app', 'Age'),
            'Nation' => Yii::t('app', 'Nation'),
            'Race' => Yii::t('app', 'Race'),
            'Religion' => Yii::t('app', 'Religion'),
            'Height' => Yii::t('app', 'Height'),
            'Weight' => Yii::t('app', 'Weight'),
            'Regadd1' => Yii::t('app', 'Regadd1'),
            'Regadd2' => Yii::t('app', 'Regadd2'),
            'Regadd3' => Yii::t('app', 'Regadd3'),
            'Regadd4' => Yii::t('app', 'Regadd4'),
            'Regadd5' => Yii::t('app', 'Regadd5'),
            'Regadd6' => Yii::t('app', 'Regadd6'),
            'Regadd7' => Yii::t('app', 'Regadd7'),
            'Nowadd1' => Yii::t('app', 'Nowadd1'),
            'Nowadd2' => Yii::t('app', 'Nowadd2'),
            'Nowadd3' => Yii::t('app', 'Nowadd3'),
            'Nowadd4' => Yii::t('app', 'Nowadd4'),
            'Nowadd5' => Yii::t('app', 'Nowadd5'),
            'Nowadd6' => Yii::t('app', 'Nowadd6'),
            'Nowadd7' => Yii::t('app', 'Nowadd7'),
            'IdcardNo' => Yii::t('app', 'Idcard No'),
            'Prefecture_Card' => Yii::t('app', 'Prefecture  Card'),
            'Province_Card' => Yii::t('app', 'Province  Card'),
            'Expire_Card' => Yii::t('app', 'Expire  Card'),
            'House' => Yii::t('app', 'House'),
            'Marry' => Yii::t('app', 'Marry'),
            'Marriage' => Yii::t('app', 'Marriage'),
            'IncomeSpouse' => Yii::t('app', 'Income Spouse'),
            'Mate_Name' => Yii::t('app', 'Mate  Name'),
            'Career_Mate' => Yii::t('app', 'Career  Mate'),
            'Workadd_Mate' => Yii::t('app', 'Workadd  Mate'),
            'Tel_Mate' => Yii::t('app', 'Tel  Mate'),
            'Child' => Yii::t('app', 'Child'),
            'FatherName' => Yii::t('app', 'Father Name'),
            'Father_Career' => Yii::t('app', 'Father  Career'),
            'Father_Age' => Yii::t('app', 'Father  Age'),
            'Father_Life' => Yii::t('app', 'Father  Life'),
            'Mother_Name' => Yii::t('app', 'Mother  Name'),
            'Mother_Career' => Yii::t('app', 'Mother  Career'),
            'Mother_Age' => Yii::t('app', 'Mother  Age'),
            'Mother_Life' => Yii::t('app', 'Mother  Life'),
            'Relative' => Yii::t('app', 'Relative'),
            'Man' => Yii::t('app', 'Man'),
            'Woman' => Yii::t('app', 'Woman'),
            'RelativeLevel' => Yii::t('app', 'Relative Level'),
            'RelateName_1' => Yii::t('app', 'Relate Name 1'),
            'RelateAge_1' => Yii::t('app', 'Relate Age 1'),
            'RelatePosition_1' => Yii::t('app', 'Relate Position 1'),
            'RelateWork_1' => Yii::t('app', 'Relate Work 1'),
            'RelateTel_1' => Yii::t('app', 'Relate Tel 1'),
            'RelateName_2' => Yii::t('app', 'Relate Name 2'),
            'RelateAge_2' => Yii::t('app', 'Relate Age 2'),
            'RelatePosition_2' => Yii::t('app', 'Relate Position 2'),
            'RelateWork_2' => Yii::t('app', 'Relate Work 2'),
            'RelateTel_2' => Yii::t('app', 'Relate Tel 2'),
            'RelateName_3' => Yii::t('app', 'Relate Name 3'),
            'RelateAge_3' => Yii::t('app', 'Relate Age 3'),
            'RelatePosition_3' => Yii::t('app', 'Relate Position 3'),
            'RelateWork_3' => Yii::t('app', 'Relate Work 3'),
            'RelateTel_3' => Yii::t('app', 'Relate Tel 3'),
            'Military' => Yii::t('app', 'Military'),
            'Military_Other' => Yii::t('app', 'Military  Other'),
            'School_1' => Yii::t('app', 'School 1'),
            'Major_1' => Yii::t('app', 'Major 1'),
            'Graduate_1' => Yii::t('app', 'Graduate 1'),
            'Grade_1' => Yii::t('app', 'Grade 1'),
            'School_2' => Yii::t('app', 'School 2'),
            'Major_2' => Yii::t('app', 'Major 2'),
            'Graduate_2' => Yii::t('app', 'Graduate 2'),
            'Grade_2' => Yii::t('app', 'Grade 2'),
            'School_3' => Yii::t('app', 'School 3'),
            'Major_3' => Yii::t('app', 'Major 3'),
            'Graduate_3' => Yii::t('app', 'Graduate 3'),
            'Grade_3' => Yii::t('app', 'Grade 3'),
            'School_4' => Yii::t('app', 'School 4'),
            'Major_4' => Yii::t('app', 'Major 4'),
            'Graduate_4' => Yii::t('app', 'Graduate 4'),
            'Grade_4' => Yii::t('app', 'Grade 4'),
            'School_5' => Yii::t('app', 'School 5'),
            'Major_5' => Yii::t('app', 'Major 5'),
            'Graduate_5' => Yii::t('app', 'Graduate 5'),
            'Grade_5' => Yii::t('app', 'Grade 5'),
            'School_6' => Yii::t('app', 'School 6'),
            'Major_6' => Yii::t('app', 'Major 6'),
            'Graduate_6' => Yii::t('app', 'Graduate 6'),
            'Grade_6' => Yii::t('app', 'Grade 6'),
            'School_7' => Yii::t('app', 'School 7'),
            'Major_7' => Yii::t('app', 'Major 7'),
            'Graduate_7' => Yii::t('app', 'Graduate 7'),
            'Grade_7' => Yii::t('app', 'Grade 7'),
            'Activity' => Yii::t('app', 'Activity'),
            'SpeakTH' => Yii::t('app', 'Speak Th'),
            'ReadTH' => Yii::t('app', 'Read Th'),
            'WriteTH' => Yii::t('app', 'Write Th'),
            'SpeakEN' => Yii::t('app', 'Speak En'),
            'ReadEN' => Yii::t('app', 'Read En'),
            'WriteEN' => Yii::t('app', 'Write En'),
            'LanguageOther' => Yii::t('app', 'Language Other'),
            'SpeakOther' => Yii::t('app', 'Speak Other'),
            'ReadOther' => Yii::t('app', 'Read Other'),
            'WriteOther' => Yii::t('app', 'Write Other'),
            'TypeTH' => Yii::t('app', 'Type Th'),
            'TypeWordTH' => Yii::t('app', 'Type Word Th'),
            'TypeEN' => Yii::t('app', 'Type En'),
            'TypeWordEN' => Yii::t('app', 'Type Word En'),
            'Fax' => Yii::t('app', 'Fax'),
            'Scan' => Yii::t('app', 'Scan'),
            'Copier' => Yii::t('app', 'Copier'),
            'EquipOther' => Yii::t('app', 'Equip Other'),
            'text_EquipOther' => Yii::t('app', 'Text  Equip Other'),
            'SpecialPrograme' => Yii::t('app', 'Special Programe'),
            'SpecialOther' => Yii::t('app', 'Special Other'),
            'Motorcye' => Yii::t('app', 'Motorcye'),
            'MotorcyeDriveLicence' => Yii::t('app', 'Motorcye Drive Licence'),
            'Car' => Yii::t('app', 'Car'),
            'CarDriveLicence' => Yii::t('app', 'Car Drive Licence'),
            'Experience' => Yii::t('app', 'Experience'),
            'WorkStart_1' => Yii::t('app', 'Work Start 1'),
            'WorkEnd_1' => Yii::t('app', 'Work End 1'),
            'Total_1' => Yii::t('app', 'Total 1'),
            'OldPosition_1' => Yii::t('app', 'Old Position 1'),
            'OldSalary_1' => Yii::t('app', 'Old Salary 1'),
            'OtherIncome_1' => Yii::t('app', 'Other Income 1'),
            'OldWorkName_1' => Yii::t('app', 'Old Work Name 1'),
            'OldWorkType_1' => Yii::t('app', 'Old Work Type 1'),
            'OldWorkAdd_1' => Yii::t('app', 'Old Work Add 1'),
            'OldSupervisor_1' => Yii::t('app', 'Old Supervisor 1'),
            'OldSuperTel_1' => Yii::t('app', 'Old Super Tel 1'),
            'OldDetailJob_1' => Yii::t('app', 'Old Detail Job 1'),
            'OldReasonResign_1' => Yii::t('app', 'Old Reason Resign 1'),
            'WorkStart_2' => Yii::t('app', 'Work Start 2'),
            'WorkEnd_2' => Yii::t('app', 'Work End 2'),
            'Total_2' => Yii::t('app', 'Total 2'),
            'OldPosition_2' => Yii::t('app', 'Old Position 2'),
            'OldSalary_2' => Yii::t('app', 'Old Salary 2'),
            'OtherIncome_2' => Yii::t('app', 'Other Income 2'),
            'OldWorkName_2' => Yii::t('app', 'Old Work Name 2'),
            'OldWorkType_2' => Yii::t('app', 'Old Work Type 2'),
            'OldWorkAdd_2' => Yii::t('app', 'Old Work Add 2'),
            'OldSupervisor_2' => Yii::t('app', 'Old Supervisor 2'),
            'OldSuperTel_2' => Yii::t('app', 'Old Super Tel 2'),
            'OldDetailJob_2' => Yii::t('app', 'Old Detail Job 2'),
            'OldReasonResign_2' => Yii::t('app', 'Old Reason Resign 2'),
            'WorkStart_3' => Yii::t('app', 'Work Start 3'),
            'WorkEnd_3' => Yii::t('app', 'Work End 3'),
            'Total_3' => Yii::t('app', 'Total 3'),
            'OldPosition_3' => Yii::t('app', 'Old Position 3'),
            'OldSalary_3' => Yii::t('app', 'Old Salary 3'),
            'OtherIncome_3' => Yii::t('app', 'Other Income 3'),
            'OldWorkName_3' => Yii::t('app', 'Old Work Name 3'),
            'OldWorkType_3' => Yii::t('app', 'Old Work Type 3'),
            'OldWorkAdd_3' => Yii::t('app', 'Old Work Add 3'),
            'OldSupervisor_3' => Yii::t('app', 'Old Supervisor 3'),
            'OldSuperTel_3' => Yii::t('app', 'Old Super Tel 3'),
            'OldDetailJob_3' => Yii::t('app', 'Old Detail Job 3'),
            'OldReasonResign_3' => Yii::t('app', 'Old Reason Resign 3'),
            'WorkStart_4' => Yii::t('app', 'Work Start 4'),
            'WorkEnd_4' => Yii::t('app', 'Work End 4'),
            'Total_4' => Yii::t('app', 'Total 4'),
            'OldPosition_4' => Yii::t('app', 'Old Position 4'),
            'OldSalary_4' => Yii::t('app', 'Old Salary 4'),
            'OtherIncome_4' => Yii::t('app', 'Other Income 4'),
            'OldWorkName_4' => Yii::t('app', 'Old Work Name 4'),
            'OldWorkType_4' => Yii::t('app', 'Old Work Type 4'),
            'OldWorkAdd_4' => Yii::t('app', 'Old Work Add 4'),
            'OldSupervisor_4' => Yii::t('app', 'Old Supervisor 4'),
            'OldSuperTel_4' => Yii::t('app', 'Old Super Tel 4'),
            'OldDetailJob_4' => Yii::t('app', 'Old Detail Job 4'),
            'OldReasonResign_4' => Yii::t('app', 'Old Reason Resign 4'),
            'WorkStart_5' => Yii::t('app', 'Work Start 5'),
            'WorkEnd_5' => Yii::t('app', 'Work End 5'),
            'Total_5' => Yii::t('app', 'Total 5'),
            'OldPosition_5' => Yii::t('app', 'Old Position 5'),
            'OldSalary_5' => Yii::t('app', 'Old Salary 5'),
            'OtherIncome_5' => Yii::t('app', 'Other Income 5'),
            'OldWorkName_5' => Yii::t('app', 'Old Work Name 5'),
            'OldWorkType_5' => Yii::t('app', 'Old Work Type 5'),
            'OldWorkAdd_5' => Yii::t('app', 'Old Work Add 5'),
            'OldSupervisor_5' => Yii::t('app', 'Old Supervisor 5'),
            'OldSuperTel_5' => Yii::t('app', 'Old Super Tel 5'),
            'OldDetailJob_5' => Yii::t('app', 'Old Detail Job 5'),
            'OldReasonResign_5' => Yii::t('app', 'Old Reason Resign 5'),
            'EmployeeName' => Yii::t('app', 'Employee Name'),
            'EmployeePosition' => Yii::t('app', 'Employee Position'),
            'EmployeeRelation' => Yii::t('app', 'Employee Relation'),
            'Penalize' => Yii::t('app', 'Penalize'),
            'PenalizeNote' => Yii::t('app', 'Penalize Note'),
            'Guarantee' => Yii::t('app', 'Guarantee'),
            'OnSite' => Yii::t('app', 'On Site'),
            'Disease' => Yii::t('app', 'Disease'),
            'DiseaseNote' => Yii::t('app', 'Disease Note'),
            'RecieveNews' => Yii::t('app', 'Recieve News'),
            'EmcName' => Yii::t('app', 'Emc Name'),
            'EmcRelate' => Yii::t('app', 'Emc Relate'),
            'EmcAdd' => Yii::t('app', 'Emc Add'),
            'EmcTel' => Yii::t('app', 'Emc Tel'),
            'date_register' => Yii::t('app', 'Date Register'),
            'updateby' => Yii::t('app', 'Updateby'),
            'lastupdate' => Yii::t('app', 'Lastupdate'),
            'total_vacation' => Yii::t('app', 'Total Vacation'),
        ];
    }
}
