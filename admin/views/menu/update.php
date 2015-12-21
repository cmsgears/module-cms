<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Menu';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'menu';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Menu</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-menu-update' ] );?>

		<div class="frm-split">
	    	<?= $form->field( $model, 'name' ) ?>
	    	<?= $form->field( $model, 'description' )->textarea() ?>
			<?= $form->field( $model, 'active' )->checkbox() ?>
		</div>

		<h4>Link Pages</h4>
		<?php foreach ( $pageLinks as $key => $pageLink ) { ?>
			<span class="box-half">
				<?= $form->field( $pageLink, "[$key]link" )->checkbox( [ 'label' => $pageLink->name ] ) ?>
				<?= $form->field( $pageLink, "[$key]pageId" )->hiddenInput()->label( false ) ?>
				<div class="frm-split">
					<?= $form->field( $pageLink, "[$key]options" )->textInput( [ "placeholder" => "html options" ] ) ?>
					<?= $form->field( $pageLink, "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
					<?= $form->field( $pageLink, "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
				</div>
			</span>
		<?php } ?>
		<div class="box-filler"></div>
		
		<div class="frm-split">
			<h4>Additional Links</h4>
			<?php foreach ( $links as $key => $link ) { ?>
			<div class="clear link">
				<span class="box-half">
					<?= $form->field( $link, "[$key]address" )->textInput( [ "placeholder" => "link address" ] ) ?>
					<?= $form->field( $link, "[$key]private" )->checkbox() ?>
					<?= $form->field( $link, "[$key]relative" )->checkbox() ?>
				</span>
				<span class="box-half">
					<?= $form->field( $link, "[$key]label" )->textInput( [ "placeholder" => "label" ] ) ?>
					<?= $form->field( $link, "[$key]options" )->textInput( [ "placeholder" => "html options" ] ) ?>
					<?= $form->field( $link, "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
					<?= $form->field( $link, "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
				</span>
			</div>
			<?php  } ?>
			<div class="box-filler"></div>
	
			<?=Html::a( "Cancel", [ '/cmgcms/menu/all' ], ['class' => 'btn' ] );?>
			<input type="submit" value="Update" />
		</div>
				
		<?php ActiveForm::end(); ?>
	</div>
</section>