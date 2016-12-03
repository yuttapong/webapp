<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_question".
 *
 * @property string $id
 * @property string $table_name
 * @property string $group_key
 * @property string $name
 * @property string $type_id
 * @property string $log_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id'], 'required'],
            [['type_id', 'created_at', 'created_by', 'status'], 'integer'],
            [['log_status'], 'string'],
            [['table_name'], 'string', 'max' => 50],
            [['group_key', 'name'], 'string', 'max' => 255],
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
            'group_key' => 'Group Key',
            'name' => 'Name',
            'type_id' => 'Type ID',
            'log_status' => 'Log Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
    public function getQuestionChoices() {
    	return $this->hasMany(QuestionChoice::className(), ['question_id' => 'id'])->orderBy('seq');
    }
    public function getDataQuestion($table,$id){
    	$modelQuestion = Question::find()->where('table_name = "'.$table.'" AND status="1" ')->all();
    	$dataq=$arrType=[];
    	foreach ($modelQuestion as $val){
    			
    		$dataq[$val->id]['question']=$val->name;
    		$dataq[$val->id]['type']=$val->type_id;
    		if($val->type_id=='4'||$val->type_id=='5' ){
    			$arrType['4']=4;
    			foreach ($val->questionChoices as $val2){
    				$dataq[$val->id]['choices'][$val2->id]=$val2->content;
    				$dataq[$val->id]['type_choices'][$val2->id]=$val2->type;
    			}
    		}elseif($val->type_id=='2'||$val->type_id=='9' ){
    			$arrType[2]=2;
    		}else{
    			$arrType[$val->type_id]=$val->type_id;
    		}
    	}
    	foreach ($arrType as $Vtype){
    		if($Vtype==4){
    			$modelChoices = ResponseChoice::find()->where('table_name = "fix_inform_fix" AND table_key="'.$id.'" AND status="1" ')->all();
    			foreach ($modelChoices as $valChoices){
    				$dataq[$valChoices->question_id]['answer'][$valChoices->choice_id]=$valChoices->id;
    			}
    			$modelChoicesOther = ResponseOther::find()->where('table_name = "fix_inform_fix" AND table_key="'.$id.'" AND status="1" ')->all();
    	
    			if(count($modelChoicesOther)>0){
    				foreach ($modelChoicesOther as $valChoicesOther){
    					$dataq[$valChoicesOther->question_id]['answerOther'][$valChoicesOther->choice_id]['other_id']=$valChoicesOther->other_id;
    					$dataq[$valChoicesOther->question_id]['answerOther'][$valChoicesOther->choice_id]['response']=$valChoicesOther->response;
    				}
    			}
    		}
    		if($Vtype==2){
    			$modelText = ResponseText::find()->where('table_name = "fix_inform_fix" AND table_key="'.$id.'" AND status="1" ')->all();
    			if(count($modelText)>0){
    				foreach ($modelText as $valText){
    					$dataq[$valText->question_id]['answer']=$valText->response;
    	
    				}
    			}
    		}
    	}
    	return $dataq;
    }
}
