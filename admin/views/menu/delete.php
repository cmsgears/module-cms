<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Menu';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Menu</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-menu-delete', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>
		<h4>Linked Pages</h4>
		<?php
			$menuPages	= $model->getPagesIdList();

			foreach ( $pages as $page ) { 

				if( in_array( $page['id'], $menuPages ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="pages" value="<?=$page['id']?>" checked disabled /><?=$page['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="pages" value="<?=$page['id']?>" disabled /><?=$page['name']?></span>
		<?php
				}
			}
		?>
		<div class="box-filler"></div>
		<?=Html::a( "Cancel", [ '/cmgcms/menu/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-page-blog", -1 );
</script>