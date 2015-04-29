<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cmsgears\core\widgets\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Page';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Page</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-page-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>
    	<?= $form->field( $model, 'summary' )->textarea() ?>

    	<h4>Page Content</h4>
    	<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Page Banner</h4>
		<div id="file-banner" class="file-container" legend="Page Banner" selector="banner" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Banner">
			<div class="file-fields">
				<input type="hidden" name="File[name]" class="file-name" value="<?php if( isset( $banner ) ) echo $banner->name; ?>" />
				<input type="hidden" name="File[extension]" class="file-extension" value="<?php if( isset( $banner ) ) echo $banner->extension; ?>" />
				<input type="hidden" name="File[directory]" value="banner" value="<?php if( isset( $banner ) ) echo $banner->directory; ?>" />
				<input type="hidden" name="File[changed]" class="file-change" value="<?php if( isset( $banner ) ) echo $banner->changed; ?>" />
				<label>Banner Description</label> <input type="text" name="File[description]" value="<?php if( isset( $banner ) ) echo $banner->description; ?>" />
				<label>Banner Alternate Text</label> <input type="text" name="File[altText]" value="<?php if( isset( $banner ) ) echo $banner->altText; ?>" />
			</div>
		</div>

		<h4>Link to Menus</h4>
		<?php foreach ( $menus as $menu ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$menu['id']?>" /><?=$menu['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/page/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-page-blog", 2 );
	initFileUploader();

	<?php if( isset( $banner ) ) { ?>
		jQuery("#file-banner .file-image").html( "<img src='<?php echo $banner->getFileUrl(); ?>' />'" );
	<?php } ?>
</script>