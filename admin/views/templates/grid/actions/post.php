<?php
use yii\helpers\Html;
?>
<span title="Comments"><?= Html::a( "", [ "post/comment/all?pid=$model->id" ], [ 'class' => 'cmti cmti-comment' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "post/gallery/direct?pid=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
