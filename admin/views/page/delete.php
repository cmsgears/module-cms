<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cmsgears\widgets\other\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Page';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Page</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-page-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'page_name' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'page_desc' )->textarea( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'page_visibility' )->dropDownList( $visibilities, [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'page_status' )->dropDownList( $status, [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'page_template' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'page_meta_tags' )->textarea( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'page_summary' )->textarea( [ 'disabled'=>'true' ] ) ?>

    	<h4>Page Content</h4>
    	<?= $form->field( $model, 'page_content' )->textarea( [ 'disabled'=>'true', 'class' => 'content-editor' ] ) ?>
    	
    	<h4>Page Banner</h4>
		<div id="file-banner" class="file-container" legend="Page Banner" selector="banner" utype="image" btn-class="btn file-input-wrap" btn-text="Change Banner">

		<h4>Linked Menus</h4>
		<?php 
			$pageMenus	= $model->getMenusIdList();

			foreach ( $menus as $menu ) { 

				if( in_array( $menu['id'], $pageMenus ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="menus" value="<?=$menu['id']?>" checked disabled /><?=$menu['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="menus" value="<?=$menu['id']?>" disabled /><?=$menu['name']?></span>
		<?php
				}
			}
		?>			
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/page/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-page-blog", -1 );
	initFileUploader();

	<?php if( isset( $banner ) ) { ?>
		jQuery("#file-banner .file-image").html( "<img src='<?php echo Yii::$app->fileManager->uploadUrl . $banner->getDisplayUrl(); ?>' />'" );
	<?php } ?>

	jQuery( ".file-input").attr( "disabled", "true" );
</script>