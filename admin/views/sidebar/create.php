<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Sidebar';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Sidebar</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-sidebar-create', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'sidebar_name' ) ?>
    	<?= $form->field( $model, 'sidebar_desc' )->textarea() ?>
		<?= $form->field( $model, 'sidebar_active' )->checkbox() ?>

		<h4>Link Widgets</h4>
		<?php foreach ( $widgets as $widget ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$widget['id']?>" /><?=$widget['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/sidebar/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-sidebar", 2 );
</script>