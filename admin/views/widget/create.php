<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Widget';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Widget</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-widget-create', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'widget_name' ) ?>
    	<?= $form->field( $model, 'widget_desc' )->textarea() ?>
		<?= $form->field( $model, 'widget_template' ) ?>
		<?= $form->field( $model, 'widget_meta' )->textarea() ?>

		<h4>Link Sidebars</h4>
		<?php foreach ( $sidebars as $sidebar ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$sidebar['id']?>" /><?=$sidebar['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/widget/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-sidebar", 4 );
</script>