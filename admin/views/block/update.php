<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Block | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
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
			<?= ImageUploader::widget([ 
					'options' => [ 'id' => 'model-banner', 'class' => 'file-uploader' ], 
					'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner' 
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Block Video</div>
			<?= VideoUploader::widget( [ 'options' => [ 'id' => 'model-video', 'class' => 'file-uploader' ], 'model' => $video ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Block Texture</div>
			<?= ImageUploader::widget([ 
					'options' => [ 'id' => 'model-texture', 'class' => 'file-uploader' ], 
					'model' => $texture, 'modelClass' => 'Texture', 'directory' => 'texture' 
			]); ?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Update" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>