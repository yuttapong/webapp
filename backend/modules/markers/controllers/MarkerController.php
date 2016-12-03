<?php
/**
 * Yii Google Maps markers
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.ho96.com
 * @copyright 2016 Hosting 96
 * @license New BSD License
 */

namespace app\modules\markers\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\modules\markers\models\Marker;
    
class MarkerController extends Controller
{
    public function actionIndex()
    {
        $markers = Marker::find()
	  ->all();
        echo $this->render('index', array('markers' => $markers));
    }

    public function actionCreate()
    {
        $model = new Marker;
        
        if(isset($_POST['Marker']))
        {
            $model->attributes = $_POST['Marker'];
            if($model->save())
                return $this->redirect(array('index'));
        }    
        
        echo $this->render('create', array('model' => $model, 'icons' => Marker::getIcons()));
    }
        	
    public function actionUpdate($id)
    {        
    $this->redirect(array('index'));
	$model = Marker::find()
	  ->where(array('id' => $id))
	  ->one();
	
	if(isset($_POST['Marker']))
	{
	    $model->attributes = $_POST['Marker'];
	    if($model->save())
		return $this->redirect(array('index'));
	}

	echo $this->render('update', array('model' => $model, 'icons' => Marker::getIcons()));   
    }

    public function actionDelete($id)
    {        
        $model = Marker::find()
	  ->where(array('id' => $id))
	  ->one();
        $model->delete(); 
        $this->redirect(array('index'));  
    }
}

