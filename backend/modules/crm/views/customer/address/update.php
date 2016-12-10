<?php
/**
 * Created by IntelliJ IDEA.
 * User: RB
 * Date: 10/12/2559
 * Time: 14:43
 */

echo $this->render('index', [
    'modelCustomer' => $modelCustomer,
    'form' => $form,
    'dataProviderAddress'=>$dataProviderAddress,
]);
