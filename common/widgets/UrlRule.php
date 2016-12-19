<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
/*
 * $url= Yii::$app->url->UrlEncode('inform-fix/index', ['id'=>'15', 'home_id'=>'','ddd'=>'xxxx']);
 * if(!empty($_GET['id'])){
	 $key= Yii::$app->url->decode($_GET['id']);
	 echo '<pre>';
	 print_r ($key);
	 echo '</pre>';
}
 */
namespace common\widgets;

use yii;

class UrlRule
{
    public function UrlEncode($route, $params)
    {
        $args = '';
        $idx = 0;
        foreach ($params as $num => $val) {
            if ($num == 'id') {
                $val = ($val);
            }
            $args .= $num . '=' . $val;
            $idx++;
            if ($idx != count($params)) $args .= '&';
        }
        $suffix = Yii::$app->urlManager->suffix;
        $arrayParams = ['p1' => 'v1', 'p2' => 'v2'];
        $params = array_merge([$route], $arrayParams);
        return [$route . $suffix, 'v' => base64_encode($args)];
    }

    public function decode($key)
    {
        $val = base64_decode($key);
        $val = explode("&", $val);
        $params = [];
        foreach ($val as $v) {
            $pa = explode("=", $v);
            $params[$pa[0]] = $pa[1];
        }

        return $params;  // this rule does not apply
    }
}

?>