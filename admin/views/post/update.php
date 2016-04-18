<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;
use cmsgears\widgets\category\CategoryMapper;
use cmsgears\widgets\tag\TagMapper;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Post | ' . $coreProperties->getSiteTitle();

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Update Post</div>
	</div>
	<div class="box-wrap-content">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-post', 'options' => [ 'class' => 'frm-split-40-60' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap ) ?>
		<?= $form->field( $model, 'status' )->dropDownList( $statusMap ) ?>
		<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap ) ?>
		<?= $form->field( $model, 'order' )->textInput() ?>
		<?= $form->field( $model, 'featured' )->checkbox() ?>
		<?= $form->field( $model, 'comments' )->checkbox() ?>

		<div class="box-content clearfix">
			<div class="header">Post Summary</div>
			<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Post Content</div>
			<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Post Banner</div>
			<?= ImageUploader::widget([
					'options' => [ 'id' => 'model-banner', 'class' => 'file-uploader' ],
					'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner'
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Post Video</div>
			<?= VideoUploader::widget( [ 'options' => [ 'id' => 'model-video', 'class' => 'file-uploader' ], 'model' => $video ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Post SEO</div>
	    	<?= $form->field( $content, 'seoName' ) ?>
	    	<?= $form->field( $content, 'seoDescription' )->textarea() ?>
	    	<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
			<?= $form->field( $content, 'seoRobot' ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Assign Categories</div>
			<?= CategoryMapper::widget([
				'options' => [ 'id' => 'box-category-mapper', 'class' => 'box-category-mapper' ],
				'type' => CmsGlobal::TYPE_POST,
				'model' => $model
			])?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Update" />
		</div>

		<?php ActiveForm::end(); ?>

		<div class="box-content clearfix">
			<div class="header">Tags</div>
			<?= TagMapper::widget([
				'options' => [ 'id' => 'box-tag-mapper', 'class' => 'box-tag-mapper' ],
				'loadAssets' => true,
				'model' => $model,
				'createUrl' => "cmgcms/post/create-tags?slug=$model->slug",
				'deleteUrl' => "cmgcms/post/delete-tag?slug=$model->slug"
			])?>
		</div>
	</div>
</div>