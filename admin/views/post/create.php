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

$coreProperties = $this->context->getCoreProperties();
$title			= $this->context->title;
$this->title 	= "Add {$title} | " . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
$apixBase		= $this->context->apixBase;

Editor::widget();

$userName = isset( $model->user ) ? $model->user->getName() . ', ' . $model->user->username . ', ' . $model->user->email : null;
?>
<div class="box-crud-wrap row max-cols-100">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-post', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row margin margin-bottom-medium">
						<div class="row row-medium">
							<?= Yii::$app->formDesigner->getAutoSuggest( $form, $model, 'userId', [
								'placeholder' => 'Search User', 'icon' => 'cmti cmti-search',
								'app' => 'core', 'controller' => 'user',
								'value' => $userName, 'url' => 'core/user/auto-search'
							]) ?>
						</div>
						<div class="note">Notes: Assign corresponding user if required.</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col2">
							<?= $form->field( $model, 'name' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'title' ) ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col2">
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea() ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
						<div class="col col2">
							<?= TextureChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'pinned' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'featured' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'popular' ) ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'comments' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'order' )->textInput() ?>
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
					<div class="row max-cols-50 padding padding-small-v">
						<div class="col col12x3">
							<label>Avatar</label>
							<?= AvatarUploader::widget( [ 'model' => $avatar, 'clearAction' => true ] ) ?>
						</div>
						<div class="col col12x3">
							<label>Banner</label>
							<?= ImageUploader::widget( [ 'model' => $banner, 'clearAction' => true ] ) ?>
						</div>
						<div class="col col12x3">
							<label>Mobile Banner</label>
							<?= ImageUploader::widget( [ 'model' => $mbanner, 'modelClass' => 'MobileBanner', 'clearAction' => true ] ) ?>
						</div>
						<div class="col col12x3">
							<label>Video</label>
							<?= VideoUploader::widget( [ 'model' => $video, 'clearAction' => true ] ) ?>
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
					<div class="row max-cols-100">
						<div class="col col2">
							<?= $form->field( $content, 'seoName' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoRobot' ) ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col2">
							<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoDescription' )->textarea() ?>
						</div>
					</div>
					<div class="row max-cols-100">
						<div class="col col1">
							<?= $form->field( $content, 'seoSchema' )->textarea() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Create" />
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
