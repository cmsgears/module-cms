<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\frontend\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\filters\UserExistFilter;

class PostController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $metaService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CoreGlobal::PERM_USER;

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
			'userExists' => [
				'class' => UserExistFilter::class,
				'actions' => [ 'like' ]
			],
			'rbac' => [
				'class' => Yii::$app->core->getRbacFilterClass(),
				'actions' => [
					// Avatar
					'assign-avatar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'clear-avatar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Banner
					'assign-banner' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'clear-banner' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Video
					'assign-video' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'clear-video' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Files
					'assign-file' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'clear-file' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Gallery Items
					'update-gallery' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'get-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'add-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'update-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'delete-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Categories
					'assign-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'toggle-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Tags
					'assign-tags' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-tag' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Metas
					'add-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'update-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'toggle-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'delete-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'settings' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Elements
					'assign-element' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-element' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Widgets
					'assign-widget' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-widget' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Sidebars
					'assign-sidebar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-sidebar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Blocks
					'assign-block' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-block' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					// Model
					'bulk' => [ 'permission' => $this->crudPermission ],
					'generic' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'delete' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					// Searching
					'auto-search' => [ 'post' ],
					// Avatar
					'assign-avatar' => [ 'post' ],
					'clear-avatar' => [ 'post' ],
					// Banner
					'assign-banner' => [ 'post' ],
					'clear-banner' => [ 'post' ],
					// Video
					'assign-video' => [ 'post' ],
					'clear-video' => [ 'post' ],
					// Files
					'assign-file' => [ 'post' ],
					'clear-file' => [ 'post' ],
					// Gallery
					'update-gallery' => [ 'post' ],
					'get-gallery-item' => [ 'post' ],
					'add-gallery-item' => [ 'post' ],
					'update-gallery-item' => [ 'post' ],
					'delete-gallery-item' => [ 'post' ],
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
					'settings' => [ 'post' ],
					// Elements
					'assign-element' => [ 'post' ],
					'remove-element' => [ 'post' ],
					// Widgets
					'assign-widget' => [ 'post' ],
					'remove-widget' => [ 'post' ],
					// Sidebars
					'assign-sidebar' => [ 'post' ],
					'remove-sidebar' => [ 'post' ],
					// Blocks
					'assign-block' => [ 'post' ],
					'remove-block' => [ 'post' ],
					// Model
					'bulk' => [ 'post' ],
					'generic' => [ 'post' ],
					'delete' => [ 'post' ],
					// Comments
					'submit-comment' => [ 'post' ],
					// Community
					'like' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			// Searching
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
			// Avatar
			'assign-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\avatar\Assign' ],
			'clear-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\avatar\Clear' ],
			// Banner
			'assign-banner' => [ 'class' => 'cmsgears\cms\common\actions\content\banner\Assign' ],
			'clear-banner' => [ 'class' => 'cmsgears\cms\common\actions\content\banner\Clear' ],
			// Video
			'assign-video' => [ 'class' => 'cmsgears\cms\common\actions\content\video\Assign' ],
			'clear-video' => [ 'class' => 'cmsgears\cms\common\actions\content\video\Clear' ],
			// Files
			'assign-file' => [ 'class' => 'cmsgears\core\common\actions\file\Assign' ],
			'clear-file' => [ 'class' => 'cmsgears\core\common\actions\file\Clear' ],
			// Gallery
			'update-gallery' => [ 'class' => 'cmsgears\cms\common\actions\gallery\Update' ],
			'get-gallery-item' => [ 'class' => 'cmsgears\cms\common\actions\gallery\item\Read' ],
			'add-gallery-item' => [ 'class' => 'cmsgears\cms\common\actions\gallery\item\Create' ],
			'update-gallery-item' => [ 'class' => 'cmsgears\cms\common\actions\gallery\item\Update' ],
			'delete-gallery-item' => [ 'class' => 'cmsgears\cms\common\actions\gallery\item\Delete' ],
			// Categories
			'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\Assign' ],
			'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\Remove' ],
			'toggle-category' => [ 'class' => 'cmsgears\core\common\actions\category\Toggle' ],
			// Tags
			'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\Assign' ],
			'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\Remove' ],
			// Metas
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Create' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Update' ],
			'toggle-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Toggle' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Delete' ],
			// Elements
			'assign-element' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-element' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			// Widgets
			'assign-widget' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-widget' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			// Sidebars
			'assign-sidebar' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-sidebar' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			// Blocks
			'assign-block' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-block' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			// Model
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'generic' => [ 'class' => 'cmsgears\core\common\actions\grid\Generic' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ],
			// Comments
			'submit-comment' => [ 'class' => 'cmsgears\core\common\actions\comment\Comment' ],
			// Community
			'like' => [ 'class' => 'cmsgears\core\common\actions\follower\Like' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

}
