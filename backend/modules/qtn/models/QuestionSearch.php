<?php

namespace backend\modules\qtn\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\qtn\Models\QtnQuestion;

/**
 * QtnQuestionSearch represents the model behind the search form about `backend\modules\qtn\Models\QtnQuestion`.
 */
class QuestionSearch extends Question
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'survey_id', 'survey_tab_id', 'survey_title_id', 'type_id', 'result_id', 'length', 'precise', 'position', 'created_at', 'created_by'], 'integer'],
            [['name', 'content', 'required', 'deleted', 'public', 'log_status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Question::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        		'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'survey_id' => $this->survey_id,
            'survey_tab_id' => $this->survey_tab_id,
            'survey_title_id' => $this->survey_title_id,
            'type_id' => $this->type_id,
            'result_id' => $this->result_id,
            'length' => $this->length,
            'precise' => $this->precise,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'required', $this->required])
            ->andFilterWhere(['like', 'deleted', $this->deleted])
            ->andFilterWhere(['like', 'public', $this->public])
            ->andFilterWhere(['like', 'log_status', $this->log_status]);

        return $dataProvider;
    }
}
