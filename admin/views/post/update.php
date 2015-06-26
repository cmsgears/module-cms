<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use cmsgears\core\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Post';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'post';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Post</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-post-update', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>

    	<h4>Post Summary</h4>
    	<?= $form->field( $model, 'summary' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Post Content</h4>
    	<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Post Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-page', 'class' => 'file-uploader' ], 'model' => $model->banner,  'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

		<h4>Post SEO</h4>
    	<?= $form->field( $model, 'seoDescription' )->textarea() ?>
    	<?= $form->field( $model, 'seoKeywords' )->textarea() ?>
		<?= $form->field( $model, 'seoRobot' ) ?>

		<h4>Assign Categories</h4>
		<?php 
			$postCategories	= $model->getCategoryIdList();

			foreach ( $categories as $category ) { 

				if( in_array( $category['id'], $postCategories ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked /><?=$category['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php
				}
			}
		?>			
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcms/post/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>