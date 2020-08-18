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

/**
 * BlockController provides actions specific to block model.
 *
 * @since 1.0.0
 */
class BlockController extends \cmsgears\core\frontend\controllers\apix\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $metaService;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Services
		$this->modelService = Yii::$app->factory->get( 'blockService' );

		$this->metaService = Yii::$app->factory->get( 'objectMetaService' );
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
					// Searching
					'auto-search' => [ 'permission' => $this->crudPermission ],
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
					// Elements
					'assign-element' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-element' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Widgets
					'assign-widget' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-widget' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Sidebars
					'assign-sidebar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'remove-sidebar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					// Model
					'bulk' => [ 'permission' => $this->crudPermission, 'user' => true ],
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
					// Elements
					'assign-element' => [ 'post' ],
					'remove-element' => [ 'post' ],
					// Widgets
					'assign-widget' => [ 'post' ],
					'remove-widget' => [ 'post' ],
					// Sidebars
					'assign-sidebar' => [ 'post' ],
					'remove-sidebar' => [ 'post' ],
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
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\ObjectSearch', 'frontend' => true ],
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
			'assign-file' => [ 'class' => 'cmsgears\core\common\actions\file\mapper\Assign' ],
			'clear-file' => [ 'class' => 'cmsgears\core\common\actions\file\mapper\Clear' ],
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
			// Elements
			'assign-element' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Assign' ],
			'remove-element' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Remove' ],
			// Widgets
			'assign-widget' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Assign' ],
			'remove-widget' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Remove' ],
			// Sidebars
			'assign-sidebar' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Assign' ],
			'remove-sidebar' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Remove' ],
			// Model
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk', 'user' => true ],
			'generic' => [ 'class' => 'cmsgears\core\common\actions\grid\Generic' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BlockController -----------------------

}
