<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\ActiveForm;
use cmsgears\icons\widgets\IconChooser;
use cmsgears\widgets\elements\mappers\LinkSuggest;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Menu | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
?>
<div class="box-crud-wrap row max-cols-100">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-menu', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row max-cols-100">
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
					<div class="row max-cols-100">
						<div class="col col2">
							<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="row max-cols-100">
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
		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Delete" />
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
		<div class="row max-cols-100">
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Links</div>
				</div>
				<div class="box-content padding padding-small">
					<?= LinkSuggest::widget([
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
