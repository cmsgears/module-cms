<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;

use cmsgears\icons\widgets\IconChooser;
use cmsgears\icons\widgets\TextureChooser;

use cmsgears\widgets\elements\mappers\ElementAuto;
use cmsgears\widgets\elements\mappers\BlockAuto;
use cmsgears\widgets\elements\mappers\WidgetAuto;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Page | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
$apixBase		= $this->context->apixBase;

$parentName = isset( $model->parent ) ? $model->parent->name : null;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true, 'fonts' => 'site', 'config' => [ 'controls' => 'mini' ] ] );
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
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'comments', null, 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'pinned', null, 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'featured', null, 'cmti cmti-checkbox' ) ?>
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
						<div class="col col12x4">
							<label>Avatar</label>
							<?= AvatarUploader::widget( [ 'model' => $avatar ] ) ?>
						</div>
						<div class="col col12x4">
							<label>Banner</label>
							<?= ImageUploader::widget( [ 'model' => $banner ] ) ?>
						</div>
						<div class="col col12x4">
							<label>Video</label>
							<?= VideoUploader::widget( [ 'model' => $video ] ) ?>
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
				</div>
			</div>
		</div>

		<div class="filler-height filler-height-medium"></div>

		<div class="align align-right">
			<?= Html::a( 'View All', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="element-medium" type="submit" value="Update" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
		<div class="row max-cols-100">
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Elements</div>
				</div>
				<div class="box-content padding padding-small">
					<?= ElementAuto::widget([
						'options' => [ 'class' => 'box-mapper-auto' ],
						'model' => $model,
						'mapActionUrl' => "$apixBase/assign-element?slug=$model->slug&type=$model->type",
						'deleteActionUrl' => "$apixBase/remove-element?slug=$model->slug&type=$model->type"
					])?>
				</div>
			</div>
			<div class="box box-crud colf colf15"> </div>
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Blocks</div>
				</div>
				<div class="box-content padding padding-small">
					<?= BlockAuto::widget([
						'options' => [ 'class' => 'box-mapper-auto' ],
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
					<?= WidgetAuto::widget([
						'options' => [ 'class' => 'box-mapper-auto' ],
						'model' => $model,
						'mapActionUrl' => "$apixBase/assign-widget?slug=$model->slug&type=$model->type",
						'deleteActionUrl' => "$apixBase/remove-widget?slug=$model->slug&type=$model->type"
					])?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
