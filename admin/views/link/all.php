<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Links | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;

// View Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ ],
	'title' => 'Links', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [
		'name' => 'Name', 'title' => 'Title', 'url' => 'Url'
	],
	'sortColumns' => [
		'name' => 'Name', 'title' => 'Title', 'url' => 'Url',
		'order' => 'Order', 'absolute' => 'Absolute',
		'private' => 'Private', 'active' => 'Active',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'model' => [
			'absolute' => 'Absolute', 'private' => 'Private',
			'active' => 'Active', 'disabled' => 'Disabled'
		]
	],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'title' => [ 'title' => 'Title', 'type' => 'text' ],
		'url' => [ 'title' => 'Url', 'type' => 'text' ],
		'absolute' => [ 'title' => 'Absolute', 'type' => 'flag' ],
		'private' => [ 'title' => 'Private', 'type' => 'flag' ],
		'active' => [ 'title' => 'Active', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'model' => [
			'absolute' => 'Absolute', 'private' => 'Private',
			'activate' => 'Activate', 'disable' => 'Disable',
			'delete' => 'Delete'
		]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, 'x2', 'x3', 'x2', 'x2', null, null, null, null ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			$icon = "<div class='align align-center'><i class=\"$model->icon\"></i></div>" ; return $icon;
		}],
		'name' => 'Name',
		'title' => 'Title',
		'page' => [ 'title' => 'Page', 'generate' => function( $model ) { return isset( $model->page ) ? $model->page->name : null; } ],
		'url' => 'Url',
		'abs' => [ 'title' => 'Abs', 'generate' => function( $model ) { return $model->getAbsoluteStr(); } ],
		'private' => [ 'title' => 'Private', 'generate' => function( $model ) { return $model->getPrivateStr(); } ],
		'active' => [ 'title' => 'Active', 'generate' => function( $model ) { return $model->getActiveStr(); } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/link",
	//'cardView' => "$moduleTemplates/grid/cards/link",
	//'actionView' => "$moduleTemplates/grid/actions/link"
])?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Menu', 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
])?>

<?= Popup::widget([
	'title' => 'Delete Menu', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Menu', 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
