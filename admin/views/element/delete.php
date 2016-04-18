<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Import
use cmsgears\core\common\widgets\Editor;
use cmsgears\icons\widgets\IconChooser;
use cmsgears\files\widgets\ImageUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Element | ' . $coreProperties->getSiteTitle();

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Element</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-widget' ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
    	<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'wrap-icon-picker clearfix' ], 'disabled' => true ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap, [ 'disabled' => 'true' ] ) ?>
		<?= $form->field( $model, 'active' )->checkbox( [ 'disabled' => 'true' ] ) ?>

		<div class="box-content clearfix">
			<div class="header">Element Banner</div>
			<?= ImageUploader::widget([
					'options' => [ 'id' => 'model-banner', 'class' => 'file-uploader' ],
					'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner'
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Element Content</div>
			<?= $form->field( $meta, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="clear filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel', [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>