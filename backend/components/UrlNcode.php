<?php
/**
 *  encode query string to base64
 *
 * Created by Yuttapong Napikun.
 * User: yuttaponk@gmail.com
 * Date: 19/12/2017
 * Time: 14:51
 */

namespace backend\components;
use yii\base\Component;
use yii\helpers\Url;

class UrlNcode extends Component
{
    /**
     * @param array $params
     * @return string
     */
    public  static function to($route = ['notify/accept', 'project_id' => 1, 'user_id' => 2])
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