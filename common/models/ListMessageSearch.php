<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ListMessage;

/**
 * ListMessageSearch represents the model behind the search form about `common\models\ListMessage`.
 */
class ListMessageSearch extends ListMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'document_id', 'table_key', 'table_key2', 'user_id', 'user_apprever_id', 'app_status', 'status', 'company_id', 'site_id', 'type'], 'integer'],
            [['table_name', 'titie', 'option', 'user_apprever_name', 'link', 'description', 'color_code'], 'safe'],
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
        $query = ListMessage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        		'sort' => ['defaultOrder'=>[
        				'app_status'=> SORT_ASC,
        				'id' => SORT_DESC,
        		]
        		]
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
            'document_id' => $this->document_id,
            'table_key' => $this->table_key,
            'table_key2' => $this->table_key2,
            'user_id' => $this->user_id,
            'user_apprever_id' => $this->user_apprever_id,
            'app_status' => $this->app_status,
            'status' => $this->status,
            'company_id' => $this->company_id,
            'site_id' => $this->site_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'titie', $this->titie])
            ->andFilterWhere(['like', 'option', $this->option])
            ->andFilterWhere(['like', 'user_apprever_name', $this->user_apprever_name])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'color_code', $this->color_code]);

        return $dataProvider;
    }
}
