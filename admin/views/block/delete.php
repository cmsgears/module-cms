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
$this->title	= 'Delete Block | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Block</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-block' ] );?>

		<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
		<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'wrap-icon-picker clearfix' ], 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
		<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap, [ 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'htmlOptions' )->textarea( [ 'readonly' => 'true' ] ) ?>
		<?= $form->field( $model, 'title' )->textInput( [ 'readonly'=>'true' ] ) ?>
		<?= $form->field( $model, 'active' )->checkbox( [ 'disabled'=>'true' ] ) ?>

		<div class="box-content clearfix">
			<div class="header">Block Content</div>
			<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Block Banner</div>
			<?= ImageUploader::widget([
					'options' => [ 'id' => 'model-banner', 'class' => 'file-uploader' ],
					'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner'
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Block Video</div>
			<?= VideoUploader::widget( [ 'options' => [ 'id' => 'model-video', 'class' => 'file-uploader' ], 'model' => $video ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Block Texture</div>
			<?= ImageUploader::widget([
					'options' => [ 'id' => 'model-texture', 'class' => 'file-uploader' ],
					'model' => $texture, 'modelClass' => 'Texture', 'directory' => 'texture'
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Linked Elements</div>
			<?php foreach ( $elements as $key => $element ) { ?>
				<span class="box-half">
					<?= $form->field( $blockElements[ $key ], "[$key]element" )->checkbox( [ 'label' => $element[ 'name' ] ] ) ?>
					<?= $form->field( $blockElements[ $key ], "[$key]elementId" )->hiddenInput( [ 'value' => $element['id'] ] )->label( false ) ?>
					<div class="frm-split-40-60 clearfix">
						<?= $form->field( $blockElements[ $key ], "[$key]htmlOptions" )->textInput( [ "readOnly" => true ] ) ?>
						<?= $form->field( $blockElements[ $key ], "[$key]order" )->textInput( [ "readOnly" => true ] ) ?>
					</div>
				</span>
			<?php } ?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>