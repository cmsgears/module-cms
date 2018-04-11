<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Posts | ' . $coreProperties->getSiteTitle();

// View Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ ],
	'title' => 'Blocks', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'name' => 'Name', 'title' => 'Title', 'desc' => 'Description', 'summary' => 'Summary', 'content' => 'Content' ],
	'sortColumns' => [
		'name' => 'Name', 'title' => 'Title', 'status' => 'Status',
		'visibility' => 'Visibility', 'order' => 'Order', 'pinned' => 'Pinned', 'featured' => 'Featured',
		'cdate' => 'Created At', 'udate' => 'Updated At', 'pdate' => 'Published At'
	],
	'filters' => [
		'status' => [ 'new' => 'New', 'active' => 'Active', 'blocked' => 'Blocked' ],
		'model' => [ 'pinned' => 'Pinned', 'featured' => 'Featured' ]
	],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'title' => [ 'title' => 'Title', 'type' => 'text' ],
		'desc' => [ 'title' => 'Description', 'type' => 'text' ],
		'summary' => [ 'title' => 'Summary', 'type' => 'text' ],
		'content' => [ 'title' => 'Content', 'type' => 'text' ],
		'status' => [ 'title' => 'Status', 'type' => 'select', 'options' => $statusMap ],
		'visibility' => [ 'title' => 'Visibility', 'type' => 'select', 'options' => $visibilityMap ],
		'order' => [ 'title' => 'Order', 'type' => 'range' ],
		'pinned' => [ 'title' => 'Pinned', 'type' => 'flag' ],
		'featured' => [ 'title' => 'Featured', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'confirmed' => 'Confirm', 'rejected' => 'Reject', 'active' => 'Activate', 'frozen' => 'Freeze', 'blocked' => 'Block' ],
		'model' => [ 'pinned' => 'Pinned', 'featured' => 'Featured', 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, 'x2', 'x2', 'x2', null, null, null, 'x2', 'x2' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			$icon = "<div class='align align-center'><i class=\"$model->icon\"></i></div>" ; return $icon;
		}],
		'name' => 'Name',
		'title' => 'Title',
		'template' => [ 'title' => 'Template', 'generate' => function( $model ) { return $model->modelContent->getTemplateName(); } ],
		'visibility' => [ 'title' => 'Visibility', 'generate' => function( $model ) { return $model->getVisibilityStr(); } ],
		'featured' => [ 'title' => 'Featured', 'generate' => function( $model ) { return $model->getFeaturedStr(); } ],
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'publishedAt'=>[ 'title' => 'Published At', 'generate' => function( $model ) { return $model->modelContent->publishedAt; } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/post",
	//'cardView' => "$moduleTemplates/grid/cards/post",
	'actionView' => "$moduleTemplates/grid/actions/post"
]) ?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Post', 'app' => 'main', 'controller' => 'crud', 'action' => 'bulk', 'url' => "cms/post/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Post', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Post', 'app' => 'main', 'controller' => 'crud', 'action' => 'delete', 'url' => "cms/post/delete?id=" ]
]) ?>
