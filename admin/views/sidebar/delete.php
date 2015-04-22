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

    	<?= $form->field( $model, 'name' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'disabled'=>'true' ] ) ?>
		<?= $form->field( $model, 'active' )->checkbox( [ 'disabled'=>'true' ] ) ?>

		<h4>Linked Widgets</h4>
		<?php foreach ( $widgets as $widget ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$widget['id']?>" disabled="true" /><?=$widget['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/sidebar/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-sidebar", -1 );
</script>