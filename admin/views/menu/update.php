<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Menu';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Menu</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-menu-update', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>

		<h4>Link Pages</h4>
		<?php 
			$menuPages	= $model->getPagesIdList();

			foreach ( $pages as $page ) { 

				if( in_array( $page['id'], $menuPages ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$page['id']?>" checked /><?=$page['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$page['id']?>" /><?=$page['name']?></span>
		<?php
				}
			}
		?>			
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcms/menu/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-page-blog", -1 );
</script>