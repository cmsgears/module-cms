<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\files\widgets\VideoUploader;
use cmsgears\icons\widgets\IconChooser;
use cmsgears\widgets\elements\mappers\WidgetAuto;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Sidebar | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-sidebar', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col3">
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'slug' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'title' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'disabled' => true, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'htmlOptions' )->textarea( [ 'readonly' => 'true' ] ) ?>
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
				<div class="box-content">
					<div class="row padding padding-small-v">
						<div class="col col12x4">
							<label>Avatar</label>
							<?= AvatarUploader::widget( [ 'model' => $avatar, 'disabled' => true ] ) ?>
						</div>
						<div class="col col12x4">
							<label>Banner</label>
							<?= ImageUploader::widget( [ 'model' => $banner, 'disabled' => true ] ) ?>
						</div>
						<div class="col col12x4">
							<label>Video</label>
							<?= VideoUploader::widget( [ 'model' => $video, 'disabled' => true ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
		<div class="row max-cols-100">
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Widgets</div>
				</div>
				<div class="box-content padding padding-small">
					<?= WidgetAuto::widget([
						'options' => [ 'class' => 'box-mapper-auto' ],
						'model' => $model, 'disabled' => true
					])?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
