<?php

use yii\bootstrap5\Html;

?>
dahsboard
 <?=Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
. Html::submitButton(Yii::$app->user->identity->username ,
['class' => 'btn btn-link logout text-decoration-none']
)
. Html::endForm();?>
