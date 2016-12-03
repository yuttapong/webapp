<?php

namespace backend\modules\fix\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\fix\models\SendDocuments;

/**
 * SendDocumentsSearch represents the model behind the search form about `backend\modules\fix\Models\SendDocuments`.
 */
class SendDocumentsSearch extends SendDocuments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'table_key', 'send_user_id', 'send_at', 'recipient_user_id', 'recipient_at', 'is_khow'], 'integer'],
            [['table_name', 'title', 'send_user_name', 'recipient_user_name', 'option'], 'safe'],
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
        $query = SendDocuments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        		'sort' => ['defaultOrder'=>[
        				'is_khow'=> SORT_ASC,
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
            'table_key' => $this->table_key,
            'send_user_id' => $this->send_user_id,
            'send_at' => $this->send_at,
            'recipient_user_id' => $this->recipient_user_id,
            'recipient_at' => $this->recipient_at,
            'is_khow' => $this->is_khow,
        ]);

        $query->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'send_user_name', $this->send_user_name])
            ->andFilterWhere(['like', 'recipient_user_name', $this->recipient_user_name])
            ->andFilterWhere(['like', 'option', $this->option]);

        return $dataProvider;
    }
}
