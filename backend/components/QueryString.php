<?php
/**
 * Created by PhpStorm.
 * User: Noom
 * Date: 19/12/2559
 * Time: 14:51
 */

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\helpers\Url;

class QueryString extends Component
{
    /**
     * @param array $params
     * @return string
     */
    public  static function encode($route, $params = ['notify/accept', 'project_id' => 1, 'user_id' => 2])
    {
        $link = Url::to($route);
        list($url,$params) =  explode('?',$link);
       return "{$url}?n=" . base64_encode($params);
    }

    /**
     * @param $url
     * @return array
     */
    public  static function decode($params)
    {
        if ($params) {
            $params = base64_decode($params);
            parse_str($params, $arrayParams);
            if (is_array($arrayParams)) {
                return $arrayParams;
            }
        }
    }

    /**
     * @param $url
     * @return string
     */
    private function _decodeUrl($link)
    {
        if (!empty($link)) {
            list($url, $params) = explode('?', $link);
            list($n, $querystring) = explode('=', $params);
            $querystring = base64_decode($querystring);
            return "{$url}?{$querystring}";
        }
    }


}