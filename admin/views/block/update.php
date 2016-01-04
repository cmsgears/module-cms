<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Block | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Update Block</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-block' ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>
    	<?= $form->field( $model, 'htmlOptions' )->textarea() ?>
		<?= $form->field( $model, 'title' ) ?>
		<?= $form->field( $model, 'icon' ) ?>
		<?= $form->field( $model, 'active' )->checkbox() ?>

		<div class="box-content clearfix">
			<div class="header">Block Content</div>
			<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Block Banner</div>
			<?= FileUploader::widget( [ 'options' => [ 'id' => 'banner-block', 'class' => 'file-uploader' ], 'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner' ] );?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Block Texture</div>
			<?= FileUploader::widget( [ 'options' => [ 'id' => 'texture-block', 'class' => 'file-uploader' ], 'model' => $banner, 'modelClass' => 'Texture', 'directory' => 'texture' ] );?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-middle">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="btn btn-medium" type="submit" value="Update" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>