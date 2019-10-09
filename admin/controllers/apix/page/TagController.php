<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\apix\page;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\behaviors\ActivityBehavior;

/**
 * TagController provides actions specific to post tags.
 *
 * @since 1.0.0
 */
class TagController extends \cmsgears\core\admin\controllers\apix\TagController {

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
					// Banner
					'assign-banner' => [ 'permission' => $this->crudPermission ],
					'clear-banner' => [ 'permission' => $this->crudPermission ],
					// Video
					'assign-video' => [ 'permission' => $this->crudPermission ],
					'clear-video' => [ 'permission' => $this->crudPermission ],
					// Files
					'assign-file' => [ 'permission' => $this->crudPermission ],
					'clear-file' => [ 'permission' => $this->crudPermission ],
					// Gallery
					'update-gallery' => [ 'permission' => $this->crudPermission ],
					'get-gallery-item' => [ 'permission' => $this->crudPermission ],
					'add-gallery-item' => [ 'permission' => $this->crudPermission ],
					'update-gallery-item' => [ 'permission' => $this->crudPermission ],
					'delete-gallery-item' => [ 'permission' => $this->crudPermission ],
					// Elements
					'assign-element' => [ 'permission' => $this->crudPermission ],
					'remove-element' => [ 'permission' => $this->crudPermission ],
					// Widgets
					'assign-widget' => [ 'permission' => $this->crudPermission ],
					'remove-widget' => [ 'permission' => $this->crudPermission ],
					// Sidebars
					'assign-sidebar' => [ 'permission' => $this->crudPermission ],
					'remove-sidebar' => [ 'permission' => $this->crudPermission ],
					// Blocks
					'assign-block' => [ 'permission' => $this->crudPermission ],
					'remove-block' => [ 'permission' => $this->crudPermission ],
					// Model
					'bulk' => [ 'permission' => $this->crudPermission ],
					'generic' => [ 'permission' => $this->crudPermission ],
					'create' => [ 'permission' => $this->crudPermission ],
					'update' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
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
					'create' => [ 'post' ],
					'update' => [ 'post' ],
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
			'create' => [ 'class' => 'cmsgears\core\common\actions\grid\Create' ],
			'update' => [ 'class' => 'cmsgears\core\common\actions\grid\Update' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TagController -------------------------

}
