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
 * SidebarController provides actions specific to sidebar model.
 *
 * @since 1.0.0
 */
class SidebarController extends \cmsgears\core\admin\controllers\apix\base\Controller {

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
		$this->modelService = Yii::$app->factory->get( 'sidebarService' );

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
					// Widgets
					'assign-widget' => [ 'permission' => $this->crudPermission ],
					'remove-widget' => [ 'permission' => $this->crudPermission ],
					// Model
					'bulk' => [ 'permission' => $this->crudPermission ],
					'generic' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					// Widgets
					'assign-widget' => [ 'post' ],
					'remove-widget' => [ 'post' ],
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
			// Widgets
			'assign-widget' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Assign' ],
			'remove-widget' => [ 'class' => 'cmsgears\core\common\actions\objectdata\mapper\Remove' ],
			// Model
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk', 'admin' => true ],
			'generic' => [ 'class' => 'cmsgears\core\common\actions\grid\Generic' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SidebarController ---------------------

}
