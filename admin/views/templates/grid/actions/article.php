<?php
use yii\helpers\Html;

$modelContent = $model->modelContent;
?>
<span title="Comments"><?= Html::a( "", [ "page/comment/all?pid=$model->id" ], [ 'class' => 'cmti cmti-comment' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "page/gallery/direct?pid=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Attributes"><?= Html::a( "", [ "page/attribute/all?pid=$model->id" ], [ 'class' => 'cmti cmti-tag' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] )  ?></span>

<?php if( isset( $modelContent->template ) && !empty( $modelContent->template->dataForm ) ) { ?>
	<span title="Template Data"><?= Html::a( "", [ "tdata?id=$model->id" ], [ 'class' => 'cmti cmti-setting-o' ] ) ?></span>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
