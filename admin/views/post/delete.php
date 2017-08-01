<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;

use cmsgears\widgets\category\CategoryAutoBox;
use cmsgears\widgets\tag\TagMapper;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Post | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true, 'fonts' => 'site', 'config' => [ 'controls' => 'mini' ] ] );
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-post', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'title' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap, [ 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<label> Page Summary </label>
							<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] )->label( false ) ?>
						</div>
						<div class="col col2">
							<label> Page Content </label>
							<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] )->label( false ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">

							<?= $form->field( $model, 'order' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
						<div class="col col2">

							<?= $form->field( $model, 'featured' )->checkbox( [ 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'comments' )->checkbox( [ 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'showGallery' )->checkbox( [ 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>

				</div>
			</div>
		</div>
		<div class="filler-height"> </div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Images</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row  padding padding-small-v">
						<div class="col col12x4">
							<label> Banner </label>
							<?= ImageUploader::widget( [ 'model' => $banner, 'disabled' => 'true' ] ) ?>
						</div>
						<div class="col col12x4">
							<label> Video </label>
							<?= VideoUploader::widget( [ 'model' => $video, 'disabled' => 'true' ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height"> </div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Page SEO</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row  padding padding-small-v">

						<div class="col col2">
							<?= $form->field( $content, 'seoName' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
					</div>
					<div class="row  padding padding-small-v">
						<div class="col col2">
							<?= $form->field( $content, 'seoKeywords' )->textarea( [ 'readonly'=>'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoDescription' )->textarea( [ 'readonly'=>'true' ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="filler-height filler-height-medium"></div>

		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>

		<div class="row max-cols-100">
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Categories</div>
				</div>
				<div class="box-content padding padding-small">
					<?= CategoryAutoBox::widget([
						'options' => [ 'class' => 'box-mapper-auto' ],
						'type' => CmsGlobal::TYPE_POST,
						'model' => $model, 'disabled' => 'true'
					]) ?>
				</div>
			</div>
			<div class="colf colf15"></div>
			<div class="box box-crud colf colf15x7">
				<div class="box-header">
					<div class="box-header-title">Tags</div>
				</div>
				<div class="box-content padding padding-small">
					<?= TagMapper::widget([
						'options' => [ 'id' => 'box-tag-mapper', 'class' => 'box-tag-mapper' ],
						'loadAssets' => true,
						'model' => $model, 'disabled' => 'true'
					])?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
