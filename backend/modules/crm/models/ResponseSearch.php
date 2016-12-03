<?php

namespace backend\modules\crm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\crm\models\Response;

/**
 * ResponseSearch represents the model behind the search form about `backend\modules\crm\models\Response`.
 */
class ResponseSearch extends Response
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['duration'], 'required'],
            [['id', 'survey_id', 'table_key', 'created_at', 'created_by', 'site_id', 'customer_id'], 'integer'],
            [['submitted', 'complete', 'username', 'table_name', 'dateStart', 'dateEnd', 'duration'], 'safe'],
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
        $query = Response::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['datetime'=>SORT_DESC]]
        ]);





        if( ! Yii::$app->user->can('crmResponseManager')){
            $query->andFilterWhere(['created_by'=>Yii::$app->user->id]);
        }

        
        $this->load($params);



        $startDate = new \DateTime($this->dateStart);
        $endDate = new  \DateTime($this->dateEnd);
        $today = new \DateTime();
        switch ($this->duration) {
            case  'today' :
                $query->andWhere([
                    "DATE_FORMAT(from_unixtime(datetime),'%Y-%m-%d')" => $today->format("Y-m-d"),
                ]);
                break;
            case  'month' :
                $query->orWhere([
                    "DATE_FORMAT(from_unixtime(datetime),'%Y-%m')" => $startDate->format("Y-m"),
                ]);
                $query->orWhere([
                    "DATE_FORMAT(from_unixtime(datetime),'%Y-%m')" => $endDate->format("Y-m"),
                ]);
                break;
            case  'year' :
                $query->orWhere([
                    'YEAR(from_unixtime(datetime))' => $startDate->format("Y"),
                ]);
                $query->orWhere([
                    'YEAR(from_unixtime(datetime))' => $endDate->format("Y"),
                ]);
                break;
            case  'specify' :
                $query->andWhere([
                        'between',
                        "DATE_FORMAT(from_unixtime(datetime),'%Y-%m-%d')",
                        $startDate->format("Y-m-d"),
                        $endDate->format("Y-m-d")]
                );
                break;
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'site_id' => $this->site_id,
            'survey_id' => $this->survey_id,
            'table_name' => Customer::TABLE_NAME,
            'created_by' => $this->created_by,
        ]);


        return $dataProvider;
    }


}
