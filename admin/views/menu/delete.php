<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Menu';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'menu';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Menu</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-menu-delete', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>

		<h4>Linked Pages</h4>
		<?php 
			$menuPages	= $model->generateObjectFromJson()->pages;

			foreach ( $pages as $page ) { 

				if( in_array( $page[ 'id' ], $menuPages ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$page['id']?>" checked disabled /><?=$page['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$page['id']?>" disabled /><?=$page['name']?></span>
		<?php
				}
			}
		?>
		<div class="box-filler"></div>
		
		<h4>Additional Links</h4>
		<?php foreach ( $links as $key => $link ) { ?>
		<div class="clear link" id='link-<?=$key?>'>
			<span class="box-half"><?= $form->field( $link, "[$key]address" )->textInput( [ "placeholder" => "link address", 'readonly'=>'true' ] ) ?></span>
			<span class="box-half"><?= $form->field( $link, "[$key]label" )->textInput( [ "placeholder" => "label", 'readonly'=>'true' ] ) ?></span>
		</div>
		<?php  } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/menu/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>