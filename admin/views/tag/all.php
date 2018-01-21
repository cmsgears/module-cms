<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Post Tags | ' . $coreProperties->getSiteTitle();

// Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
?>

<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ ],
	'title' => 'Tags', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'name' => 'Name', 'desc' => 'Description' ],
	'sortColumns' => [
		'name' => 'Name', 'slug' => 'Slug'
	],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'slug' => [ 'title' => 'Slug', 'type' => 'text' ],
		'desc' => [ 'title' => 'Description', 'type' => 'text' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null ,'x4', 'x2','x7', null ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'name' => 'Name',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) { return "<i class=\"$model->icon\"></i>"; } ],
		'description' => 'Description',
		'actions'	=> 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => '@themes/admin/views/templates/widget/grid',
	//'dataView' => "$moduleTemplates/grid/data/tag",
	//'cardView' => "$moduleTemplates/grid/cards/tag",
	//'actionView' => "$moduleTemplates/grid/actions/tag"
]) ?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'bulk',
	'data' => [ 'model' => 'Tag', 'app' => 'main', 'controller' => 'crud', 'action' => 'bulk', 'url' => "cms/tag/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Tag', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'delete',
	'data' => [ 'model' => 'Tag', 'app' => 'main', 'controller' => 'crud', 'action' => 'delete', 'url' => "cms/tag/delete?id=" ]
]) ?>
