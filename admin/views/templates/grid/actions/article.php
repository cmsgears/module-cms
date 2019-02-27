<?php
use yii\helpers\Html;

$modelContent	= $model->modelContent;
$template		= $modelContent->template;
?>
<span title="Comments"><?= Html::a( "", [ "article/comment/all?pid=$model->id" ], [ 'class' => 'cmti cmti-comment' ] ) ?></span>
<span title="Files"><?= Html::a( "", [ "article/file/all?pid=$model->id" ], [ 'class' => 'cmti cmti-file' ] ) ?></span>
<span title="Attributes"><?= Html::a( "", [ "article/attribute/all?pid=$model->id" ], [ 'class' => 'cmti cmti-tag' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "article/gallery?id=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>

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

<span class="action action-pop action-delete cmti cmti-bin" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
