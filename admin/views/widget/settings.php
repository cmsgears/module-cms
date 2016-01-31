<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Widget Settings';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'widget';

$template	= isset( $templatesMap[ $model->templateId ] ) ? $templatesMap[ $model->templateId ] : null;
?>
<section class="wrap-content container clearfix">
	<div class="cud-box frm-split">
		<h2>Widget Settings</h2>
		<div><label>Name</label><label><?=$model->name?></label></div>
		<div><label>Description</label><label><?=$model->description?></label></div>
		<div><label>Template</label><label><?=$template?></label></div>
		<div><label>Class Path</label><label><?=$meta->classPath?></label></div>

		<div class="filler-space"></div>

		<?php
			if( isset( $theme ) ) {

				if( isset( $template ) ) {
	
					$template	=  $model->template;
	
					echo $this->render( $theme->basePath . '/' . $template->viewPath . '/' . $template->adminView, [ 'model' => $meta ] );
				}
			}
			else {
		?>
				<p>No active theme found.</p>
		<?php
			}
		?>
	</div>
</section>