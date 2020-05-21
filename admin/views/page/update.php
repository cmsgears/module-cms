<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\ActiveForm;
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;

use cmsgears\icons\widgets\IconChooser;
use cmsgears\icons\widgets\TextureChooser;

use cmsgears\widgets\elements\mappers\ElementSuggest;
use cmsgears\widgets\elements\mappers\BlockSuggest;
use cmsgears\widgets\elements\mappers\WidgetSuggest;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Page | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
$apixBase		= $this->context->apixBase;
$parentName		= isset( $model->parentId ) ? $model->parent->name : null;

Editor::widget();
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-page', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col3">
							<?= $form->field( $model, 'name' ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'slug' ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'title' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea() ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'comments' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'pinned' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'featured' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'publishedAt' )->textInput( [ 'class' => 'datepicker' ] ) ?>
						</div>
						<div class="col col2">
							<?= Yii::$app->formDesigner->getAutoSuggest( $form, $model, 'parentId', [ 'placeholder' => 'Parent', 'icon' => 'cmti cmti-search', 'type' => $model->type, 'value' => $parentName, 'url' => 'cms/page/auto-search' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
						<div class="col col2">
							<?= TextureChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'classPath' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'viewPath' ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Files</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row padding padding-small-v">
						<div class="col col12x3">
							<label>Avatar</label>
							<?= AvatarUploader::widget([
								'model' => $avatar, 'clearAction' => true,
								'clearActionUrl' => "$apixBase/clear-avatar?slug=$model->slug&type=$model->type"
							])?>
						</div>
						<div class="col col12x3">
							<label>Banner</label>
							<?= ImageUploader::widget([
								'model' => $banner, 'clearAction' => true,
								'clearActionUrl' => "$apixBase/clear-banner?slug=$model->slug&type=$model->type"
							])?>
						</div>
						<div class="col col12x3">
							<label>Mobile Banner</label>
							<?= ImageUploader::widget([
								'model' => $mbanner, 'modelClass' => 'MobileBanner', 'clearAction' => true,
								'clearActionUrl' => "$apixBase/clear-mbanner?slug=$model->slug&type=$model->type"
							])?>
						</div>
						<div class="col col12x3">
							<label>Video</label>
							<?= VideoUploader::widget([
								'model' => $video, 'clearAction' => true,
								'clearActionUrl' => "$apixBase/clear-video?slug=$model->slug&type=$model->type"
							])?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Summary</div>
			</div>
			<div class="box-content-wysiwyg">
				<div class="box-content">
					<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Content</div>
			</div>
			<div class="box-content-wysiwyg">
				<div class="box-content">
					<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Page SEO</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'seoName' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoRobot' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoDescription' )->textarea() ?>
						</div>
					</div>
					<div class="row">
						<div class="col col1">
							<?= $form->field( $content, 'seoSchema' )->textarea() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="align align-right">
			<?= Html::a( 'View All', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Update" />
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
		<div class="row max-cols-100">
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Elements</div>
				</div>
				<div class="box-content padding padding-small">
					<?= ElementSuggest::widget([
						'model' => $model,
						'mapActionUrl' => "$apixBase/assign-element?slug=$model->slug&type=$model->type",
						'deleteActionUrl' => "$apixBase/remove-element?slug=$model->slug&type=$model->type"
					])?>
				</div>
			</div>
			<div class="colf colf15"> </div>
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Blocks</div>
				</div>
				<div class="box-content padding padding-small">
					<?= BlockSuggest::widget([
						'model' => $model,
						'mapActionUrl' => "$apixBase/assign-block?slug=$model->slug&type=$model->type",
						'deleteActionUrl' => "$apixBase/remove-block?slug=$model->slug&type=$model->type"
					])?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="row max-cols-100">
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Widgets</div>
				</div>
				<div class="box-content padding padding-small">
					<?= WidgetSuggest::widget([
						'model' => $model,
						'mapActionUrl' => "$apixBase/assign-widget?slug=$model->slug&type=$model->type",
						'deleteActionUrl' => "$apixBase/remove-widget?slug=$model->slug&type=$model->type"
					])?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3"></div>
</div>
