<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Post';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'post';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Post</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-post-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap ) ?>

    	<h4>Post Summary</h4>
    	<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Post Content</h4>
    	<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Post Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-page', 'class' => 'file-uploader' ], 'model' => $content->banner,  'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

		<h4>Post SEO</h4>
    	<?= $form->field( $content, 'seoName' ) ?>
    	<?= $form->field( $content, 'seoDescription' )->textarea() ?>
    	<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
		<?= $form->field( $content, 'seoRobot' ) ?>

		<h4>Assign Categories</h4>
		<?php foreach ( $categories as $category ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/post/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>