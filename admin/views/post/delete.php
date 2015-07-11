<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Post';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'post';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Post</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-post-delete', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap, [ 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'disabled' => true ] ) ?>

    	<h4>Post Summary</h4>
    	<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] ) ?>

    	<h4>Post Content</h4>
    	<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] ) ?>

    	<h4>Post Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-page', 'class' => 'file-uploader' ], 'model' => $content->banner,  'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

		<h4>Post SEO</h4>
		<?= $form->field( $content, 'seoName' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $content, 'seoDescription' )->textarea( [ 'readonly' => 'true' ] ) ?>
    	<?= $form->field( $content, 'seoKeywords' )->textarea( [ 'readonly' => 'true' ] ) ?>
		<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readonly'=>'true' ] ) ?>

		<h4>Assign Categories</h4>
		<?php 
			$postCategories	= $model->getCategoryIdList();

			foreach ( $categories as $category ) { 

				if( in_array( $category['id'], $postCategories ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked disabled /><?=$category['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" disabled /><?=$category['name']?></span>
		<?php
				}
			}
		?>			
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/post/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>