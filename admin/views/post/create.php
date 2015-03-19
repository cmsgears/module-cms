<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cmsgears\widgets\other\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Post';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Post</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-post-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'page_name' ) ?>
    	<?= $form->field( $model, 'page_desc' )->textarea() ?>
    	<?= $form->field( $model, 'page_template' ) ?>
    	<?= $form->field( $model, 'page_meta_tags' )->textarea() ?>
    	<?= $form->field( $model, 'page_summary' )->textarea() ?>

    	<h4>Post Content</h4>
    	<?= $form->field( $model, 'page_content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Post Banner</h4>
		<div id="file-banner" class="file-container" legend="Page Banner" selector="banner" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Banner">
			<div class="file-fields">
				<input type="hidden" name="File[file_name]" class="file-name" value="<?php if( isset( $banner ) ) echo $banner->getName(); ?>" />
				<input type="hidden" name="File[file_extension]" class="file-extension" value="<?php if( isset( $banner ) ) echo $banner->getExtension(); ?>" />
				<input type="hidden" name="File[file_directory]" value="banner" value="<?php if( isset( $banner ) ) echo $banner->getDirectory(); ?>" />
				<input type="hidden" name="File[changed]" class="file-change" value="<?php if( isset( $banner ) ) echo $banner->changed; ?>" />
				<label>Banner Description</label> <input type="text" name="File[file_desc]" value="<?php if( isset( $banner ) ) echo $banner->getDesc(); ?>" />
				<label>Banner Alternate Text</label> <input type="text" name="File[file_alt_text]" value="<?php if( isset( $banner ) ) echo $banner->getAltText(); ?>" />
			</div>
		</div>

		<h4>Assign Categories</h4>
		<?php foreach ( $categories as $category ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php } ?>
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcms/post/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-page-blog", 8 );
	initFileUploader();

	<?php if( isset( $banner ) ) { ?>
		jQuery("#file-banner .file-image").html( "<img src='<?php echo Yii::$app->fileManager->uploadUrl . $banner->getDisplayUrl(); ?>' />'" );
	<?php } ?>
</script>