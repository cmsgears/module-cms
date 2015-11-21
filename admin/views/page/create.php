<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Page';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'page';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Page</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-page-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( ArrayHelper::merge( [ '0' => 'Choose Template' ], $templatesMap ) ) ?>
		<?= $form->field( $model, 'status' )->dropDownList( $statusMap ) ?>
		<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap ) ?>

    	<h4>Page Summary</h4>
    	<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Page Content</h4>
    	<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Page Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-page', 'class' => 'file-uploader' ], 'model' => $content->banner,  'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

		<h4>Page SEO</h4>
    	<?= $form->field( $content, 'seoName' ) ?>
    	<?= $form->field( $content, 'seoDescription' )->textarea() ?>
    	<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
		<?= $form->field( $content, 'seoRobot' ) ?>

		<?=Html::a( 'Cancel', [ '/cmgcms/page/all' ], [ 'class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>