<?php
/**
 * Yii quiz
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.oligalma.com
 * @copyright 2016 Oligalma
 * @license GPL License
 */

use yii\web\View;
use yii\helpers\Html;
use app\modules\quiz\controllers\SiteController;

$this->title='Quiz';

$this->registerJs('
    $(".category").click(function(){
        $("#wait").css("display", "block");
    });
',View::POS_END, 'quizjs');

$this->registerCss('
    .center
    {
        text-align:center;    
    }
    
	@media all and (min-width: 650px)
	{
		#quizrules
		{
			width:550px;
		}
	}
');
?>
<h1 class="center">Web design quizzes</h1>
<p style="text-align:center;font-size:20px;">
<?php
foreach($categories as $category):
	echo Html::a($category->name . ' (' . $category->questionCount . ' questions)', array("site/start", 'category' => $category->id), array('class' => 'category'));
?>
<br/>
<?php
endforeach;
?>
</p>
<p style="text-align:center;">
	<ul id="quizrules" style="padding:10px;margin:0 auto;">
		<li>You have just <?= SiteController::SECONDS_PER_QUESTION ?> seconds to answer each question.
		<?php
		if(SiteController::MINIMUM_SCORE !== false):
		?>
		<li>If you get <?= SiteController::MINIMUM_SCORE ?>% or more, you will be able to download a diploma!<br/>
		<?php
		endif;
		?>
	</ul> 
</p>
<div id="wait" style="top:25%;left:0%;width:100%;text-align:center;display:none;position:fixed">
	<?= Html::img(Yii::$app->controller->module->assetsUrl. '/images/loading.gif', array('style' => 'background:white;border:1px solid black;')); ?>
</div>