<?php
/**
 * Yii Google Maps markers
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.ho96.com
 * @copyright 2016 Hosting 96
 * @license New BSD License
 */
?>
<h1>Create marker</h1>

<?php
echo $this->context->renderPartial('_form',array('model'=>$model, 'icons' => $icons));
?>