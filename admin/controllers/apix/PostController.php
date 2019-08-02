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

use cmsgears\core\common\behaviors\ActivityBehavior;

/**
 * PostController provides actions specific to post model.
 *
 * @since 1.0.0
 */
class PostController extends \cmsgears\core\admin\controllers\base\Controller {

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
					'assign-avatar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'clear-avatar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Banner
					'assign-banner' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'clear-banner' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Video
					'assign-video' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'clear-video' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Files
					'assign-file' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'clear-file' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Gallery
					'update-gallery' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'get-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'add-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'update-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'delete-gallery-item' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Categories
					'assign-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'toggle-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Tags
					'assign-tags' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-tag' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Metas
					'add-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'update-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'toggle-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'delete-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'settings' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Elements
					'assign-element' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-element' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Widgets
					'assign-widget' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-widget' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Sidebars
					'assign-sidebar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-sidebar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Blocks
					'assign-block' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-block' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Data Object - Reserved
					'set-data' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-data' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'set-attribute' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-attribute' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'set-config' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-config' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'set-setting' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-setting' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Data Object - Custom
					'set-custom' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-custom' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Model
					'bulk' => [ 'permission' => $this->crudPermission ],
					'generic' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'delete' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ]
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
					// Data Object - Reserved
					'set-data' => [ 'post' ],
					'remove-data' => [ 'post' ],
					'set-attribute' => [ 'post' ],
					'remove-attribute' => [ 'post' ],
					'set-config' => [ 'post' ],
					'remove-config' => [ 'post' ],
					'set-setting' => [ 'post' ],
					'remove-setting' => [ 'post' ],
					// Data Object - Custom
					'set-custom' => [ 'post' ],
					'remove-custom' => [ 'post' ],
					// Model
					'bulk' => [ 'post' ],
					'generic' => [ 'post' ],
					'delete' => [ 'post' ],
					// Reviews
					'submit-comment' => [ 'post' ],
					// Community
					'like' => [ 'post' ]
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
			// Data Object - Reserved
			'set-data' => [ 'class' => 'cmsgears\core\common\actions\data\data\Set' ],
			'remove-data' => [ 'class' => 'cmsgears\core\common\actions\data\data\Remove' ],
			'set-attribute' => [ 'class' => 'cmsgears\core\common\actions\data\attribute\Set' ],
			'remove-attribute' => [ 'class' => 'cmsgears\core\common\actions\data\attribute\Remove' ],
			'set-config' => [ 'class' => 'cmsgears\core\common\actions\data\config\Set' ],
			'remove-config' => [ 'class' => 'cmsgears\core\common\actions\data\config\Remove' ],
			'set-setting' => [ 'class' => 'cmsgears\core\common\actions\data\setting\Set' ],
			'remove-setting' => [ 'class' => 'cmsgears\core\common\actions\data\setting\Remove' ],
			// Data Object - Custom
			'set-custom' => [ 'class' => 'cmsgears\core\common\actions\data\custom\Set' ],
			'remove-custom' => [ 'class' => 'cmsgears\core\common\actions\data\custom\Remove' ],
			// Model
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'generic' => [ 'class' => 'cmsgears\core\common\actions\grid\Generic' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ],
			// Reviews
			'submit-comment' => [ 'class' => 'cmsgears\core\common\actions\comment\Comment' ],
			// Community
			'like' => [ 'class' => 'cmsgears\core\common\actions\follower\Like' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

}
