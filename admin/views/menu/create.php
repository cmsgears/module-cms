<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Menu';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'menu';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Menu</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-menu-create' ] );?>
		
		<div class="frm-split">
	    	<?= $form->field( $model, 'name' ) ?>
	    	<?= $form->field( $model, 'description' )->textarea() ?>
			<?= $form->field( $model, 'active' )->checkbox() ?>
		</div>

		<h4>Link Pages</h4>
		<?php foreach ( $pages as $key => $page ) { ?>
			<span class="box-half">
				<?= $form->field( $pageLinks[ $key ], "[$key]link" )->checkbox( [ 'label' => $page[ 'name' ] ] ) ?>
				<?= $form->field( $pageLinks[ $key ], "[$key]pageId" )->hiddenInput( [ 'value' => $page['id'] ] )->label( false ) ?>
				<div class="frm-split">
					<?= $form->field( $pageLinks[ $key ], "[$key]htmlOptions" )->textInput( [ "placeholder" => "html options" ] ) ?>
					<?= $form->field( $pageLinks[ $key ], "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
					<?= $form->field( $pageLinks[ $key ], "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
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
					<?= $form->field( $link, "[$key]htmlOptions" )->textInput( [ "placeholder" => "html options" ] ) ?>
					<?= $form->field( $link, "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
					<?= $form->field( $link, "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
				</span>
			</div>
			<?php  } ?>
			<div class="box-filler"></div>
	
			<?=Html::a( "Cancel", [ '/cmgcms/menu/all' ], ['class' => 'btn' ] );?>
			<input type="submit" value="Create" />
		</div>
				
		<?php ActiveForm::end(); ?>
	</div>
</section>