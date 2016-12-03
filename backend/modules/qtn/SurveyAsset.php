<?php
namespace backend\modules\qtn;

use yii\web\AssetBundle;

class SurveyAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@backend/modules/qtn/assets';
	/**
	 * @inheritdoc
	 */
	public $css = [
			'css/radio.css'
	];

	public $js = [
		//	'js/requestion.js'
	];

	public $depends = [
			'yii\jui\JuiAsset',
	];

}
