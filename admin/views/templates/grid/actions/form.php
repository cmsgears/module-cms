<?php
// Yii Imports
use yii\helpers\Html;

$submits		= $widget->data[ 'submits' ];
$modelContent	= $model->modelContent;
?>

<?php if( $submits ) { ?>
	<span title="Submits"><?= Html::a( "", [ "/forms/form/submit/all?fid=$model->id" ], [ 'class' => 'cmti cmti-checkbox-b-active' ] ) ?></span>
<?php } ?>

<span title="Fields"><?= Html::a( "", [ "/forms/form/field/all?fid=$model->id" ], [ 'class' => 'cmti cmti-list-small' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "form/gallery/direct?pid=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] ) ?></span>
<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] ) ?></span>

<?php if( isset( $modelContent->template ) && !empty( $modelContent->template->dataForm ) ) { ?>
	<span title="Template Data"><?= Html::a( "", [ "tdata?id=$model->id" ], [ 'class' => 'cmti cmti-setting-o' ] ) ?></span>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
