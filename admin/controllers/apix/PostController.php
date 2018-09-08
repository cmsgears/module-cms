<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\admin\controllers\base\Controller;

use cmsgears\core\common\behaviors\ActivityBehavior;

/**
 * PostController provides actions specific to post model.
 *
 * @since 1.0.0
 */
class PostController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $metaService;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService	= Yii::$app->factory->get( 'postService' );
		$this->metaService	= Yii::$app->factory->get( 'pageMetaService' );
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
					// Avatar
					'avatar' => [ 'permission' => $this->crudPermission ],
					'clear-avatar' => [ 'permission' => $this->crudPermission ],
					// Banner
					'banner' => [ 'permission' => $this->crudPermission ],
					'clear-banner' => [ 'permission' => $this->crudPermission ],
					// Categories
					'assign-category' => [ 'permission' => $this->crudPermission ],
					'remove-category' => [ 'permission' => $this->crudPermission ],
					'toggle-category' => [ 'permission' => $this->crudPermission ],
					// Tags
					'assign-tags' => [ 'permission' => $this->crudPermission ],
					'remove-tag' => [ 'permission' => $this->crudPermission ],
					// Metas
					'add-meta' => [ 'permission' => $this->crudPermission ],
					'update-meta' => [ 'permission' => $this->crudPermission ],
					'toggle-meta' => [ 'permission' => $this->crudPermission ],
					'delete-meta' => [ 'permission' => $this->crudPermission ],
					// Elements
					'assign-element' => [ 'permission' => $this->crudPermission ],
					'remove-element' => [ 'permission' => $this->crudPermission ],
					// Blocks
					'assign-block' => [ 'permission' => $this->crudPermission ],
					'remove-block' => [ 'permission' => $this->crudPermission ],
					// Widgets
					'assign-widget' => [ 'permission' => $this->crudPermission ],
					'remove-widget' => [ 'permission' => $this->crudPermission ],
					// Model
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					// Searching
					'auto-search' => [ 'post' ],
					// Avatar
					'avatar' => [ 'post' ],
					'clear-avatar' => [ 'post' ],
					// Banner
					'banner' => [ 'post' ],
					'clear-banner' => [ 'post' ],
					// Categories
					'assign-category' => [ 'post' ],
					'remove-category' => [ 'post' ],
					'toggle-category' => [ 'post' ],
					// Tags
					'assign-tags' => [ 'post' ],
					'remove-tag' => [ 'post' ],
					// Metas
					'add-meta' => [ 'post' ],
					'update-meta' => [ 'post' ],
					'toggle-meta' => [ 'post' ],
					'delete-meta' => [ 'post' ],
					// Elements
					'assign-element' => [ 'post' ],
					'remove-element' => [ 'post' ],
					// Blocks
					'assign-block' => [ 'post' ],
					'remove-block' => [ 'post' ],
					// Widgets
					'assign-widget' => [ 'post' ],
					'remove-widget' => [ 'post' ],
					// Model
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ]
				]
			],
			'activity' => [
				'class' => ActivityBehavior::class,
				'admin' => true,
				'delete' => [ 'delete' ]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			// Searching
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
			// Avatar
			'avatar' => [ 'class' => 'cmsgears\core\common\actions\content\Avatar' ],
			'clear-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\ClearAvatar' ],
			// Banner
			'banner' => [ 'class' => 'cmsgears\cms\common\actions\content\Banner' ],
			'clear-banner' => [ 'class' => 'cmsgears\cms\common\actions\content\ClearBanner' ],
			// Categories
			'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\Assign' ],
			'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\Remove' ],
			'toggle-category' => [ 'class' => 'cmsgears\core\common\actions\category\Toggle' ],
			// Tags
			'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\Assign' ],
			'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\Remove' ],
			// Metas
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\CreateMeta' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\UpdateMeta' ],
			'toggle-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Toggle' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\DeleteMeta' ],
			// Elements
			'assign-element' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-element' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			// Blocks
			'assign-block' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-block' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			// Widgets
			'assign-widget' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-widget' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			// Model
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

}
