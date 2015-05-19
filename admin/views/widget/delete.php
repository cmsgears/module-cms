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

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap, [ 'disabled'=>'true' ] ) ?>

		<h4>Linked Sidebars</h4>
		<?php 
			$widgetSidebars	= $model->getSidebarsIdList();

			foreach ( $sidebars as $sidebar ) { 

				if( in_array( $sidebar['id'], $widgetSidebars ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$sidebar['id']?>" checked disabled /><?=$sidebar['name']?></span>
		<?php
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$sidebar['id']?>" disabled /><?=$sidebar['name']?></span>
		<?php
				}
			}
		?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/widget/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-sidebar", 2 );
</script>