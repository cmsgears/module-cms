<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Widget';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'widget';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Widget</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-sidebar-delete', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap, [ 'disabled'=>'true' ] ) ?>
		<?= $form->field( $model, 'active' )->checkbox( [ 'disabled'=>'true' ] ) ?>

		<?=Html::a( "Cancel", [ '/cmgcms/widget/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>