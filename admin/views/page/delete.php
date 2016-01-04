<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\FileUploader;
use cmsgears\files\widgets\VideoUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Page | ' . $coreProperties->getSiteTitle();

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Page</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-page' ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap, [ 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'icon' )->textInput( [ 'readonly'=>'true' ] ) ?>

		<div class="box-content clearfix">
			<div class="header">Page Summary</div>
			<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page Content</div>
			<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page Banner</div>
			<?= FileUploader::widget( [ 'options' => [ 'id' => 'banner-block', 'class' => 'file-uploader' ], 'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner' ] );?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page Video</div>
			<?= VideoUploader::widget( [ 'options' => [ 'id' => 'video-listing', 'class' => 'file-uploader' ], 'model' => $video, 'modelClass' => 'Video' ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Page SEO</div>
			<?= $form->field( $content, 'seoName' )->textInput( [ 'readonly'=>'true' ] ) ?>
	    	<?= $form->field( $content, 'seoDescription' )->textarea( [ 'readonly' => 'true' ] ) ?>
	    	<?= $form->field( $content, 'seoKeywords' )->textarea( [ 'readonly' => 'true' ] ) ?>
			<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readonly'=>'true' ] ) ?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-middle">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="btn btn-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>