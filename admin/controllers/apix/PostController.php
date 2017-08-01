<?php
namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class PostController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'postService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		return [
			'rbac' => [
				'class' => Yii::$app->core->getRbacFilterClass(),
				'actions' => [
					'update-avatar' => [ 'permission' => $this->crudPermission ],
					'update-banner' => [ 'permission' => $this->crudPermission ],
					'assign-category' => [ 'permission' => $this->crudPermission ],
					'remove-category' => [ 'permission' => $this->crudPermission ],
					'assign-tags' => [ 'permission' => $this->crudPermission ],
					'remove-tag' => [ 'permission' => $this->crudPermission ],
					'add-meta' => [ 'permission' => $this->crudPermission ],
					'update-meta' => [ 'permission' => $this->crudPermission ],
					'delete-meta' => [ 'permission' => $this->crudPermission ],
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'auto-search' => [ 'post' ],
					'update-avatar' => [ 'post' ],
					'update-banner' => [ 'post' ],
					'assign-category' => [ 'post' ],
					'remove-category' => [ 'post' ],
					'assign-tags' => [ 'post' ],
					'remove-tag' => [ 'post' ],
					'add-meta' => [ 'post' ],
					'update-meta' => [ 'post' ],
					'delete-meta' => [ 'post' ],
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
			'update-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateAvatar' ],
			'update-banner' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateContentBanner' ],
			'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\AssignCategory', 'typed' => true, 'parentType' => CmsGlobal::TYPE_POST ],
			'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\RemoveCategory', 'typed' => true, 'parentType' => CmsGlobal::TYPE_POST ],
			'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\AssignTags', 'typed' => true, 'parentType' => CmsGlobal::TYPE_POST ],
			'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\RemoveTag', 'typed' => true, 'parentType' => CmsGlobal::TYPE_POST ],
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\CreateMeta' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\UpdateMeta' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\DeleteMeta' ],
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

}
