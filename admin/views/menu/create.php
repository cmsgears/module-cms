<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Add Menu | ' . $coreProperties->getSiteTitle();
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Add Menu</div>
	</div>
	<div class="box-wrap-content">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-menu' ] );?>

		<div class="frm-split frm-split-40-60 clearfix">
	    	<?= $form->field( $model, 'name' ) ?>
	    	<?= $form->field( $model, 'description' )->textarea() ?>
			<?= $form->field( $model, 'active' )->checkbox() ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Link Pages</div>
			<?php foreach ( $pages as $key => $page ) { ?>
				<span class="box-half">
					<?= $form->field( $pageLinks[ $key ], "[$key]link" )->checkbox( [ 'label' => $page[ 'name' ] ] ) ?>
					<?= $form->field( $pageLinks[ $key ], "[$key]pageId" )->hiddenInput( [ 'value' => $page['id'] ] )->label( false ) ?>
					<div class="frm-split-40-60 clearfix">
						<?= $form->field( $pageLinks[ $key ], "[$key]htmlOptions" )->textInput( [ "placeholder" => "html options" ] ) ?>
						<?= $form->field( $pageLinks[ $key ], "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
						<?= $form->field( $pageLinks[ $key ], "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
					</div>
				</span>
			<?php } ?>
		</div>

		<div class="box-content frm-split-40-60 clearfix">
			<div class="header">Additional Links</div>
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
		</div>

		<div class="filler-height"></div>

		<div class="align align-middle">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="btn btn-medium" type="submit" value="Create" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>