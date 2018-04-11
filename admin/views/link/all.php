<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Links | ' . $coreProperties->getSiteTitle();

// View Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ ],
	'title' => 'Blocks', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'name' => 'Name', 'url' => 'Url' ],
	'sortColumns' => [
		'name' => 'Name', 'url' => 'Url', 'order' => 'Order',
		'target' => 'Target', 'absolute' => 'Absolute', 'blog' => 'Blog',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'status' => [ 'new' => 'New', 'active' => 'Active', 'blocked' => 'Blocked' ]
	],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'url' => [ 'title' => 'Url', 'type' => 'text' ],
		'order' => [ 'title' => 'Order', 'type' => 'text' ],
		'target' => [ 'title' => 'Target', 'type' => 'flag' ],
		'absolute' => [ 'title' => 'Absolute', 'type' => 'flag' ],
		'blog' => [ 'title' => 'Blog', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'active' => 'Activate', 'blocked' => 'Block' ],
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, 'x3', 'x6', null, null, null, null ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			$icon = "<div class='align align-center'><i class=\"$model->icon\"></i></div>" ; return $icon;
		}],
		'name' => 'Name',
		'url' => 'Url',
		'target' => [ 'title' => 'Target', 'generate' => function( $model ) { return $model->getTargetStr(); } ],
		'abs' => [ 'title' => 'Abs', 'generate' => function( $model ) { return $model->getAbsoluteStr(); } ],
		'blog' => [ 'title' => 'Blog', 'generate' => function( $model ) { return $model->getBlogStr(); } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/link",
	//'cardView' => "$moduleTemplates/grid/cards/link",
	//'actionView' => "$moduleTemplates/grid/actions/link"
]) ?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Menu', 'app' => 'main', 'controller' => 'crud', 'action' => 'bulk', 'url' => "cms/link/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Menu', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Menu', 'app' => 'main', 'controller' => 'crud', 'action' => 'delete', 'url' => "cms/link/delete?id=" ]
]) ?>
