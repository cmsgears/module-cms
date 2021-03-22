<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\widgets\ActiveForm;
use cmsgears\core\common\widgets\Editor;
use cmsgears\widgets\popup\Popup;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Review Post | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
$apixBase		= $this->context->apixBase;
$modelContent	= $model->modelContent;

Editor::widget();

$reviewIncludes = Yii::getAlias( '@cmsgears' ) . '/module-cms/admin/views/includes/review';

// Services -----------------------

$categoryService	= Yii::$app->factory->get( 'categoryService' );
$optionService		= Yii::$app->factory->get( 'optionService' );

// Approval -----------------------

$title		= 'Post';
$modelClass	= $modelService->getModelClass();

// Basic --------------------------

// Attributes ---------------------

$metas = $model->getMetasByType( CoreGlobal::META_TYPE_USER );

// Files --------------------------

$gallery		= $modelContent->gallery;
$galleryFiles	= isset( $gallery ) ? $gallery->modelFiles : [];

// Settings -----------------------

?>
<div class="box-crud-wrap">
	<div class="box-crud-wrap-main margin margin-small">
		<div class="filler-height filler-height-medium"></div>
		<?php include "$reviewIncludes/post/approval.php"; ?>
		<div class="filler-height filler-height-medium"></div>
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-post', 'options' => [ 'class' => 'form' ] ] ); ?>
		<?php include "$reviewIncludes/post/basic.php"; ?>
		<?php if( count( $metas ) > 0 ) { ?>
			<div class="filler-height filler-height-medium"></div>
			<?php include "$reviewIncludes/post/attributes.php"; ?>
		<?php } ?>
		<div class="filler-height filler-height-medium"></div>
		<?php include "$reviewIncludes/post/files.php"; ?>
		<div class="filler-height filler-height-medium"></div>
		<?php include "$reviewIncludes/post/settings.php"; ?>
		<div class="filler-height filler-height-medium"></div>
		<?php include "$reviewIncludes/post/content.php"; ?>
		<div class="filler-height filler-height-medium"></div>
		<?php include "$reviewIncludes/post/seo.php"; ?>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<?= Popup::widget([
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/popup/lightbox' ), 'template' => 'slider'
])?>
