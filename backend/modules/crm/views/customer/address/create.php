<?php
/**
 * Created by IntelliJ IDEA.
 * User: RB
 * Date: 10/12/2559
 * Time: 14:43
 */

echo $this->render('_form-type-contact', [
    'modelCustomer' => $modelCustomer,
    'form' => $form,
    'modelAddress'=>$modelAddressContact,
]);

echo $this->render('_form-type-office', [
    'modelCustomer' => $modelCustomer,
    'form' => $form,
    'modelAddress'=>$modelAddressOffice,
]);