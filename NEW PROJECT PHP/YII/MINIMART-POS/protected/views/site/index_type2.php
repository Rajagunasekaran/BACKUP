<?php 
$this->renderPartial('//order/admin',array(
    'model'=>$model,
    'origin' => $origin,
    'options' => $options,
    'fromdb' => $fromdb,
    'timeslotmodel' => $timeslotmodel,
));
?>