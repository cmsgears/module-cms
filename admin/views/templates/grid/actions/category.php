<?php
use yii\helpers\Html;

$parentPath = $widget->data[ 'parentPath' ];

$modelContent	= $model->modelContent;
$template		= $modelContent->template;
?>
<span title="Files"><?= Html::a( "", [ "$parentPath/model-file/all?pid=$model->id" ], [ 'class' => 'cmti cmti-file' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "$parentPath/gallery?id=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] ) ?></span>

<?php if( isset( $template ) ) { ?>
	<?php if( !empty( $template->dataForm ) ) { ?>
		<span title="Data"><?= Html::a( "", [ "data?id=$model->id" ], [ 'class' => 'cmti cmti-briefcase' ] ) ?></span>
	<?php } ?>
	<?php if( !empty( $template->attributesForm ) ) { ?>
		<span title="Attributes"><?= Html::a( "", [ "attributes?id=$model->id" ], [ 'class' => 'cmti cmti cmti-tag-o' ] ) ?></span>
	<?php } ?>
	<?php if( !empty( $template->configForm ) ) { ?>
		<span title="Config"><?= Html::a( "", [ "config?id=$model->id" ], [ 'class' => 'cmti cmti-setting-o' ] ) ?></span>
	<?php } ?>
	<?php if( !empty( $template->settingsForm ) ) { ?>
		<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] ) ?></span>
	<?php } ?>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-bin" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
