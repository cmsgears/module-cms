<?php
use yii\helpers\Html;
?>

<span title="Attributes"><?= Html::a( "", [ "element/attribute/all?pid=$model->id" ], [ 'class' => 'cmti cmti-tag' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] )  ?></span>
<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
