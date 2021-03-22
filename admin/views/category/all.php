<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= $this->context->title . ' Categories | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;
$parentPath		= $this->context->parentPath;

// View Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ 'parentPath' => $parentPath ],
	'title' => 'Categories', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [
		'name' => 'Name', 'title' => 'Title', 'desc' => 'Description',
		'summary' => 'Summary', 'content' => 'Content'
	],
	'sortColumns' => [
		'name' => 'Name', 'title' => 'Title', 'order' => 'Order',
		'pinned' => 'Pinned', 'featured' => 'Featured', 'popular' => 'Popular'
	],
	'filters' => [
		'model' => [
			'pinned' => 'Pinned', 'featured' => 'Featured', 'popular' => 'Popular',
			'top' => 'Top Level'
		]
	],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'title' => [ 'title' => 'Title', 'type' => 'text' ],
		'desc' => [ 'title' => 'Description', 'type' => 'text' ],
		'summary' => [ 'title' => 'Summary', 'type' => 'text' ],
		'content' => [ 'title' => 'Content', 'type' => 'text' ],
		'order' => [ 'title' => 'Order', 'type' => 'range' ],
		'pinned' => [ 'title' => 'Pinned', 'type' => 'flag' ],
		'featured' => [ 'title' => 'Featured', 'type' => 'flag' ],
		'popular' => [ 'title' => 'Popular', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'model' => [
			'pinned' => 'Pinned', 'featured' => 'Featured', 'popular' => 'Popular',
			'delete' => 'Delete'
		]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, 'x2', 'x2', 'x2', 'x2', null, null, null, 'x2' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			$icon = "<div class='align align-center'><i class='fa-2x " . $model->icon ."'></i></div>" ; return $icon;
		}],
		'name' => 'Name',
		'title' => 'Title',
		'root' => [ 'title' => 'Root', 'generate' => function( $model ) { return $model->getRootName(); } ],
		'parent' => [ 'title' => 'Parent', 'generate' => function( $model ) { return $model->getParentName(); } ],
		'template' => [ 'title' => 'Template', 'generate' => function( $model ) { return $model->modelContent->getTemplateName(); } ],
		'pinned' => [ 'title' => 'Pinned', 'generate' => function( $model ) { return $model->getPinnedStr(); } ],
		'featured' => [ 'title' => 'Featured', 'generate' => function( $model ) { return $model->getFeaturedStr(); } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/category",
	//'cardView' => "$moduleTemplates/grid/cards/category",
	'actionView' => "$moduleTemplates/grid/actions/category"
])?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Category', 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
])?>

<?= Popup::widget([
	'title' => 'Delete Category', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Category', 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
