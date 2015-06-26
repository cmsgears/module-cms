<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use cmsgears\core\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Page';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'page';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Page</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-page-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( ArrayHelper::merge( [ '0' => 'Choose Template' ], $templatesMap ) ) ?>

    	<h4>Page Summary</h4>
    	<?= $form->field( $model, 'summary' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Page Content</h4>
    	<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Page Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-page', 'class' => 'file-uploader' ], 'model' => $model->banner,  'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

		<h4>Page SEO</h4>
    	<?= $form->field( $model, 'seoDescription' )->textarea() ?>
    	<?= $form->field( $model, 'seoKeywords' )->textarea() ?>
		<?= $form->field( $model, 'seoRobot' ) ?>

		<h4>Link to Menus</h4>
		<?php 
			$pageMenus	= $model->getMenusIdList();

			foreach ( $menus as $menu ) { 

				if( in_array( $menu['id'], $pageMenus ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$menu['id']?>" checked /><?=$menu['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$menu['id']?>" /><?=$menu['name']?></span>
		<?php
				}
			}
		?>
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcms/page/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>