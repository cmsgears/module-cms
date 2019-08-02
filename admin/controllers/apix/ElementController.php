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

/**
 * ElementController provides actions specific to element model.
 *
 * @since 1.0.0
 */
class ElementController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService = Yii::$app->factory->get( 'elementService' );
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
					// Metas
					'add-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'update-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'toggle-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'delete-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
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
					// Metas
					'add-meta' => [ 'post' ],
					'update-meta' => [ 'post' ],
					'toggle-meta' => [ 'post' ],
					'delete-meta' => [ 'post' ],
					// Model
					'bulk' => [ 'post' ],
					'generic' => [ 'post' ],
					'delete' => [ 'post' ]
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
			'assign-banner' => [ 'class' => 'cmsgears\core\common\actions\content\banner\Assign' ],
			'clear-banner' => [ 'class' => 'cmsgears\core\common\actions\content\banner\Clear' ],
			// Video
			'assign-video' => [ 'class' => 'cmsgears\core\common\actions\content\video\Assign' ],
			'clear-video' => [ 'class' => 'cmsgears\core\common\actions\content\video\Clear' ],
			// Files
			'assign-file' => [ 'class' => 'cmsgears\core\common\actions\file\Assign' ],
			'clear-file' => [ 'class' => 'cmsgears\core\common\actions\file\Clear' ],
			// Gallery
			'update-gallery' => [ 'class' => 'cmsgears\core\common\actions\gallery\Update' ],
			'get-gallery-item' => [ 'class' => 'cmsgears\core\common\actions\gallery\item\Read' ],
			'add-gallery-item' => [ 'class' => 'cmsgears\core\common\actions\gallery\item\Create' ],
			'update-gallery-item' => [ 'class' => 'cmsgears\core\common\actions\gallery\item\Update' ],
			'delete-gallery-item' => [ 'class' => 'cmsgears\core\common\actions\gallery\item\Delete' ],
			// Metas
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Create' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Update' ],
			'toggle-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Toggle' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Delete' ],
			// Model
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'generic' => [ 'class' => 'cmsgears\core\common\actions\grid\Generic' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ElementController ---------------------

}
