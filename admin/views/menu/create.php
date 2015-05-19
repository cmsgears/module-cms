<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Menu';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Menu</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-menu-create', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>

		<h4>Link Pages</h4>
		<?php foreach ( $pages as $page ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$page['id']?>" /><?=$page['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/menu/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-page-blog", 1 );
</script>