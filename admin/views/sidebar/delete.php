<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Sidebar';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Sidebar</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-sidebar-delete', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>

		<h4>Linked Widgets</h4>
		<?php 
			$sidebarWidgets	= $model->getWidgetsIdList();

			foreach ( $widgets as $widget ) { 

				if( in_array( $widget['id'], $sidebarWidgets ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$widget['id']?>" checked disabled /><?=$widget['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$widget['id']?>" disabled /><?=$widget['name']?></span>
		<?php
				}
			}
		?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/sidebar/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-sidebar", -1 );
</script>