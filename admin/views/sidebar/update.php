<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Sidebar';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-sdebar';
$this->params['sidebar-child'] 	= 'sdebar';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Sidebar</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-sidebar-update', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>

		<h4>Link Widgets</h4>
		<?php 
			$sidebarWidgets	= $model->generateObjectFromJson()->widgets;

			foreach ( $widgets as $widget ) { 

				if( in_array( $widget['id'], $sidebarWidgets ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$widget['id']?>" checked /><?=$widget['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$widget['id']?>" /><?=$widget['name']?></span>
		<?php
				}
			}
		?>
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcms/sidebar/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>