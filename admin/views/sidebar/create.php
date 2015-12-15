<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Sidebar';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'sdebar';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Sidebar</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-sidebar-create', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
		<?= $form->field( $model, 'active' )->checkbox() ?>

		<h4>Link Widgets</h4>
		<?php foreach ( $widgets as $key => $widget ) { ?>
			<span class="box-half">
				<?= $form->field( $sidebarWidgets[ $key ], "[$key]widget" )->checkbox( [ 'label' => $widget[ 'name' ] ] ) ?>
				<?= $form->field( $sidebarWidgets[ $key ], "[$key]widgetId" )->hiddenInput( [ 'value' => $widget['id'] ] )->label( false ) ?>
				<div class="frm-split">
					<?= $form->field( $sidebarWidgets[ $key ], "[$key]options" )->textInput( [ "placeholder" => "html options" ] ) ?>
					<?= $form->field( $sidebarWidgets[ $key ], "[$key]icon" )->textInput( [ "placeholder" => "label" ] ) ?>
					<?= $form->field( $sidebarWidgets[ $key ], "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
				</div>
			</span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/sidebar/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>