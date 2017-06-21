<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;
use cmsgears\icons\widgets\IconChooser;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Add Page | ' . $coreProperties->getSiteTitle();

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Add Page</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-page' ] );?>

		<?= $form->field( $model, 'name' ) ?>
		<?= $form->field( $model, 'description' )->textarea() ?>
		<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'wrap-icon-picker clearfix' ] ] ) ?>
		<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap ) ?>
		<?= $form->field( $model, 'status' )->dropDownList( $statusMap ) ?>
		<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap ) ?>
		<?= $form->field( $model, 'comments' )->checkbox() ?>

		<div class="box-content clearfix">
			<div class="header">Page Summary</div>
			<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page Content</div>
			<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page Banner</div>
			<?= ImageUploader::widget([
					'options' => [ 'id' => 'model-banner', 'class' => 'file-uploader' ],
					'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner'
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page Video</div>
			<?= VideoUploader::widget( [ 'options' => [ 'id' => 'model-video', 'class' => 'file-uploader' ], 'model' => $video ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page SEO</div>
			<?= $form->field( $content, 'seoName' ) ?>
			<?= $form->field( $content, 'seoDescription' )->textarea() ?>
			<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
			<?= $form->field( $content, 'seoRobot' ) ?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Create" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>