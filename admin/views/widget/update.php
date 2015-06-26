<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Widget';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-sdebar';
$this->params['sidebar-child'] 	= 'widget';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Widget</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-widget-update', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
		<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>

		<h4>Link Sidebars</h4>
		<?php 
			$widgetSidebars	= $model->getSidebarsIdList();

			foreach ( $sidebars as $sidebar ) { 

				if( in_array( $sidebar['id'], $widgetSidebars ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$sidebar['id']?>" checked /><?=$sidebar['name']?></span>
		<?php
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$sidebar['id']?>" /><?=$sidebar['name']?></span>
		<?php
				}
			}
		?>
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcms/widget/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>