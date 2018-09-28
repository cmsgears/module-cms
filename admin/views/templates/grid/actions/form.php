<?php
// Yii Imports
use yii\helpers\Html;

$submits		= $widget->data[ 'submits' ];
$modelContent	= $model->modelContent;
$template		= $modelContent->template;
?>

<?php if( $submits ) { ?>
	<span title="Submits"><?= Html::a( "", [ "/forms/form/submit/all?fid=$model->id" ], [ 'class' => 'cmti cmti-checkbox-b-active' ] ) ?></span>
<?php } ?>

<span title="Fields"><?= Html::a( "", [ "/forms/form/field/all?fid=$model->id" ], [ 'class' => 'cmti cmti-list-small' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "form/gallery/direct?pid=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] ) ?></span>

<?php if( isset( $template ) ) { ?>
	<?php if( !empty( $template->dataForm ) ) { ?>
		<span title="Data"><?= Html::a( "", [ "data?id=$model->id" ], [ 'class' => 'cmti cmti-briefcase' ] ) ?></span>
	<?php } ?>
	<?php if( !empty( $template->configForm ) ) { ?>
		<span title="Config"><?= Html::a( "", [ "config?id=$model->id" ], [ 'class' => 'cmti cmti-setting-o' ] ) ?></span>
	<?php } ?>
	<?php if( !empty( $template->settingsForm ) ) { ?>
		<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] ) ?></span>
	<?php } ?>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>