<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cmsgears\core\widgets\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Post';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Post</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-post-update', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
    	<?= $form->field( $model, 'keywords' )->textarea() ?>
    	<?= $form->field( $model, 'visibility' )->dropDownList( $visibilities ) ?>
    	<?= $form->field( $model, 'status' )->dropDownList( $status ) ?>
    	<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>
    	<?= $form->field( $model, 'summary' )->textarea() ?>
 
    	<h4>Post Content</h4>
    	<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>
    	
    	<h4>Post Banner</h4>
		<div id="file-banner" class="file-container" legend="Post Banner" selector="banner" utype="image" btn-class="btn file-input-wrap" btn-text="Change Banner">
			<div class="file-fields">
				<input type="hidden" name="File[id]" value="<?php if( isset( $banner ) ) echo $banner->id; ?>" />
				<input type="hidden" name="File[name]" class="file-name" value="<?php if( isset( $banner ) ) echo $banner->name; ?>" />
				<input type="hidden" name="File[extension]" class="file-extension" value="<?php if( isset( $banner ) ) echo $banner->extension; ?>" />
				<input type="hidden" name="File[directory]" value="banner" value="<?php if( isset( $banner ) ) echo $banner->directory; ?>" />
				<input type="hidden" name="File[changed]" class="file-change" value="<?php if( isset( $banner ) ) echo $banner->changed; ?>" />
				<label>Banner Description</label> <input type="text" name="File[description]" value="<?php if( isset( $banner ) ) echo $banner->description; ?>" />
				<label>Banner Alternate Text</label> <input type="text" name="File[altText]" value="<?php if( isset( $banner ) ) echo $banner->altText; ?>" />
			</div>
		</div>

		<h4>Assign Categories</h4>
		<?php 
			$postCategories	= $model->getCategoriesIdList();

			foreach ( $categories as $category ) { 

				if( in_array( $category['id'], $postCategories ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked /><?=$category['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php
				}
			}
		?>			
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcms/post/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-page-blog", 5 );
	initFileUploader();

	<?php if( isset( $banner ) ) { ?>
		jQuery("#file-banner .file-image").html( "<img src='<?php echo $banner->getFileUrl(); ?>' />'" );
	<?php } ?>
</script>