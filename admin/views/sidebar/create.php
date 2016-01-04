<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Add Sidebar | ' . $coreProperties->getSiteTitle();
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Add Sidebar</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-sidebar' ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
		<?= $form->field( $model, 'active' )->checkbox() ?>

		<div class="box-content clearfix">
			<div class="header">Link Widgets</div>
			<?php foreach ( $widgets as $key => $widget ) { ?>
				<span class="box-half">
					<?= $form->field( $sidebarWidgets[ $key ], "[$key]widget" )->checkbox( [ 'label' => $widget[ 'name' ] ] ) ?>
					<?= $form->field( $sidebarWidgets[ $key ], "[$key]widgetId" )->hiddenInput( [ 'value' => $widget['id'] ] )->label( false ) ?>
					<div class="frm-split-40-60 clearfix">
						<?= $form->field( $sidebarWidgets[ $key ], "[$key]htmlOptions" )->textInput( [ "placeholder" => "html options" ] ) ?>
						<?= $form->field( $sidebarWidgets[ $key ], "[$key]icon" )->textInput( [ "placeholder" => "label" ] ) ?>
						<?= $form->field( $sidebarWidgets[ $key ], "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
					</div>
				</span>
			<?php } ?>
		</div>

		<div class="clear filler-height"></div>

		<div class="align align-middle">
			<?=Html::a( 'Cancel', [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="btn btn-medium" type="submit" value="Create" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>