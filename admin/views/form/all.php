<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$title			= $this->context->title;
$this->title	= "{$title}s | " . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;

// View Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ 'submits' => true ],
	'title' => $this->title, 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [
		'name' => 'Name', 'title' => 'Title', 'desc' => 'Description',
		'success' => 'Success', 'failure' => 'Failure',
		'summary' => 'Summary', 'content' => 'Content'
	],
	'sortColumns' => [
		'name' => 'Name', 'title' => 'Title', 'status' => 'Status',
		'visibility' => 'Visibility', 'template' => 'template',
		'captcha' => 'Captcha', 'umail' => 'User Mail', 'amail' => 'Admin Mail',
		'uqsubmit' => 'Unique Submit', 'upsubmit' => 'Update Submit',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'status' => [
			'new' => 'New', 'submitted' => 'Submitted', 're-submitted' => 'Re Submitted',
			'rejected' => 'Rejected', 'active' => 'Active',
			'frozen' => 'Frozen', 'uplift-freeze' => 'Uplift Freeze',
			'blocked' => 'Blocked', 'uplift-block' => 'Uplift Block',
			'terminated' => 'Terminated'
		],
		'model' => [
			'captcha' => 'Captcha', 'umail' => 'User Mail', 'amail' => 'Admin Mail',
			'uqsubmit' => 'Unique Submit', 'upsubmit' => 'Update Submit'
		]
	],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'title' => [ 'title' => 'Title', 'type' => 'text' ],
		'desc' => [ 'title' => 'Description', 'type' => 'text' ],
		'success' => [ 'title' => 'Success Message', 'type' => 'text' ],
		'failure' => [ 'title' => 'Failure Message', 'type' => 'text' ],
		'summary' => [ 'title' => 'Summary', 'type' => 'text' ],
		'content' => [ 'title' => 'Content', 'type' => 'text' ],
		'captcha' => [ 'title' => 'Captcha', 'type' => 'flag' ],
		'status' => [ 'title' => 'Status', 'type' => 'select', 'options' => $statusMap ],
		'visibility' => [ 'title' => 'Visibility', 'type' => 'select', 'options' => $visibilityMap ],
		'umail' => [ 'title' => 'User Mail', 'type' => 'flag' ],
		'amail' => [ 'title' => 'Admin Mail', 'type' => 'flag' ],
		'uqsubmit' => [ 'title' => 'Unique Submit', 'type' => 'flag' ],
		'upsubmit' => [ 'title' => 'Update Submit', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [
			'reject' => 'Reject', 'approve' => 'Approve', 'activate' => 'Activate',
			'freeze' => 'Freeze', 'block' => 'Block', 'terminate' => 'Terminate'
		],
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, null, 'x2', null, null, null, null, null, null, null, null, 'x2' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			return "<div class='align align-center'><i class=\"$model->icon\"></i></div>" ;
		}],
		'name' => 'Name',
		'title' => 'Title',
		'template' => [ 'title' => 'Template', 'generate' => function( $model ) {
			return isset( $model->modelContent->template ) ? $model->modelContent->template->name : null;
		}],
		'captcha' => [ 'title' => 'Captcha', 'generate' => function( $model ) { return $model->getCaptchaStr(); } ],
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'visibility' => [ 'title' => 'Visibility', 'generate' => function( $model ) { return $model->getVisibilityStr(); } ],
		'userMail' => [ 'title' => 'User Mail', 'generate' => function( $model ) { return $model->getUserMailStr(); } ],
		'adminMail' => [ 'title' => 'Admin Mail', 'generate' => function( $model ) { return $model->getAdminMailStr(); } ],
		'uqsubmit' => [ 'title' => 'Unique Submit', 'generate' => function( $model ) { return $model->getUniqueSubmitStr(); } ],
		'upsubmit' => [ 'title' => 'Update Submit', 'generate' => function( $model ) { return $model->getUpdateSubmitStr(); } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/form",
	//'cardView' => "$moduleTemplates/grid/cards/form",
	'actionView' => "$moduleTemplates/grid/actions/form"
])?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
])?>

<?= Popup::widget([
	'title' => "Delete $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
