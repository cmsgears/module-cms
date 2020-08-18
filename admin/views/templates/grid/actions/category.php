<?php
use yii\helpers\Html;

$parentPath = $widget->data[ 'parentPath' ];
?>
<span title="Files"><?= Html::a( "", [ "$parentPath/model-file/all?pid=$model->id" ], [ 'class' => 'cmti cmti-file' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "$parentPath/gallery?id=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] )  ?></span>

<span class="action action-pop action-delete cmti cmti-bin" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
