<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\ActiveForm;
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;
use cmsgears\icons\widgets\IconChooser;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Tag | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

Editor::widget();
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-tag', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col3">
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => true ] ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'slug' )->textInput( [ 'readonly' => true ] ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'title' )->textInput( [ 'readonly' => true ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'disabled' => true, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => true ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Files</div>
			</div>
			<div class="box-content">
				<div class="row padding padding-small-v">
					<div class="col col12x4">
						<label>Banner</label>
						<?= ImageUploader::widget( [ 'model' => $banner, 'disabled' => 'true' ] ) ?>
					</div>
					<div class="col col12x4">
						<label>Video</label>
						<?= VideoUploader::widget( [ 'model' => $video, 'disabled' => 'true' ] ) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Summary</div>
			</div>
			<div class="box-content-wysiwyg">
				<div class="box-content">
					<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Content</div>
			</div>
			<div class="box-content-wysiwyg">
				<div class="box-content">
					<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Page SEO</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'seoName' )->textInput( [ 'readonly' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readonly' => true ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'seoKeywords' )->textarea( [ 'readonly' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoDescription' )->textarea( [ 'readonly' => true ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="filler-height filler-height-medium"></div>

		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Delete" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
