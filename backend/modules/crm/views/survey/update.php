<?php/** * Created by PhpStorm. * User: RB * Date: 24/9/2559 * Time: 9:26 */$this->title =  'แก้ไขแบบสำรวจ';$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลลูกค้า', 'url' => ['customer/index']];$this->params['breadcrumbs'][] = $this->title ;?><h1><?=$model->name?></h1><?= $this->render('_form', [    'model' => $model,    'questions' => $questions,    'searchQ' => $searchQ,]) ?>