<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Menu';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'menu';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Menu</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-menu-create', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
		<?= $form->field( $model, 'active' )->checkbox() ?>

		<h4>Link Pages</h4>
		<?php foreach ( $pages as $page ) { ?>
			<span class="box-half"><input type="checkbox" name="BinderPage[bindedData][]" value="<?=$page['id']?>" /><?=$page['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<h4>Additional Links</h4>
		<?php foreach ( $links as $key => $link ) { ?>
		<div class="clear link" id='link-<?=$key?>'>
			<span class="box-half">
				<?= $form->field( $link, "[$key]address" )->textInput( [ "placeholder" => "link address" ] ) ?>
				<?= $form->field( $link, "[$key]relative" )->checkbox() ?>
			</span>
			<span class="box-half"><?= $form->field( $link, "[$key]label" )->textInput( [ "placeholder" => "label" ] ) ?></span>
		</div>
		<?php  } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/menu/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>