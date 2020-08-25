<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\ActiveForm;
use cmsgears\icons\widgets\IconChooser;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Link | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

$pageName = isset( $model->page ) ? $model->page->name : null;
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-sidebar', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col5x2">
							<?= $form->field( $model, 'url' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col5 align align-center">
							OR
						</div>
						<div class="col col5x2">
							<?= Yii::$app->formDesigner->getAutoSuggest( $form, $model, 'pageId', [ 'placeholder' => 'Page', 'icon' => 'cmti cmti-search', 'value' => $pageName, 'disabled' => true, 'url' => 'cms/page/auto-search' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'url' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'absolute', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'private', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'order' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'htmlOptions' )->textarea( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'urlOptions' )->textarea( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'disabled' => true, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="align align-right">
			<?= Html::a( 'Cancle', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Delete" />
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
