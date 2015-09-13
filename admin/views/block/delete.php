<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Block';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'block';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Block</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-block-delete', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( ArrayHelper::merge( [ '0' => 'Choose Template' ], $templatesMap ), [ 'disabled' => true ] ) ?>
    	<?= $form->field( $model, 'htmlOptions' )->textInput( [ 'readonly'=>'true' ] ) ?>
		<?= $form->field( $model, 'backgroundClass' )->textInput( [ 'readonly'=>'true' ] ) ?>
		<?= $form->field( $model, 'textureClass' )->textInput( [ 'readonly'=>'true' ] ) ?>

    	<h4>Block Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-block', 'class' => 'file-uploader' ], 'model' => $banner,  'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

    	<h4>Block Texture</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'texture-block', 'class' => 'file-uploader' ], 'model' => $texture,  'directory' => 'texture', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

    	<h4>Block Video</h4>
		<?=FileUploader::widget([
			'options' => [ 'id' => 'video-block', 'class' => 'file-uploader' ], 
			'model' => $video, 'directory' => 'video', 'type' => 'video', 
			'btnChooserIcon' => 'icon-action icon-action-edit' 
		]);?>

		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/block/all' ], [ 'class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>