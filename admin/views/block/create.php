<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Block';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'block';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Block</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-block-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( ArrayHelper::merge( [ '0' => 'Choose Template' ], $templatesMap ) ) ?>
    	<?= $form->field( $model, 'htmlOptions' ) ?>
		<?= $form->field( $model, 'backgroundClass' ) ?>
		<?= $form->field( $model, 'textureClass' ) ?>
		<?= $form->field( $model, 'title' ) ?>
		<?= $form->field( $model, 'active' )->checkbox() ?>

    	<h4>Block Content</h4>
    	<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>

    	<h4>Block Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-block', 'class' => 'file-uploader' ], 'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

    	<h4>Block Texture</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'texture-block', 'class' => 'file-uploader' ], 'model' => $texture, 'modelClass' => 'Texture', 'directory' => 'texture', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

    	<h4>Block Video</h4>
		<?=FileUploader::widget([
			'options' => [ 'id' => 'video-block', 'class' => 'file-uploader' ], 
			'model' => $video, 'modelClass' => 'Video', 'directory' => 'video', 'type' => 'video', 
			'btnChooserIcon' => 'icon-action icon-action-edit' 
		]);?>

		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/block/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>