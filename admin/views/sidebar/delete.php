<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Sidebar';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'sdebar';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Sidebar</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-sidebar-delete', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
		<?= $form->field( $model, 'active' )->checkbox( [ 'disabled'=>'true' ] ) ?>

		<h4>Linked Widgets</h4>
		<?php foreach ( $sidebarWidgets as $key => $sidebarWidget ) { ?>
			<span class="box-half">
				<?= $form->field( $sidebarWidget, "[$key]widget" )->checkbox( [ 'label' => $sidebarWidget->name ] ) ?>
				<?= $form->field( $sidebarWidget, "[$key]widgetId" )->hiddenInput()->label( false ) ?>
				<div class="frm-split">
					<?= $form->field( $sidebarWidget, "[$key]htmlOptions" )->textInput( [ "placeholder" => "html options" ] ) ?>
					<?= $form->field( $sidebarWidget, "[$key]icon" )->textInput( [ "placeholder" => "label" ] ) ?>
					<?= $form->field( $sidebarWidget, "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
				</div>
			</span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/sidebar/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>