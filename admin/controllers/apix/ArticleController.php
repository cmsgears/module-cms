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
 * ArticleController provides actions specific to article model.
 *
 * @since 1.0.0
 */
class ArticleController extends Controller {

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
		$this->modelService	= Yii::$app->factory->get( 'articleService' );
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
					'update-avatar' => [ 'permission' => $this->crudPermission ],
					'update-banner' => [ 'permission' => $this->crudPermission ],
					'add-meta' => [ 'permission' => $this->crudPermission ],
					'update-meta' => [ 'permission' => $this->crudPermission ],
					'delete-meta' => [ 'permission' => $this->crudPermission ],
					'assign-element' => [ 'permission' => $this->crudPermission ],
					'remove-element' => [ 'permission' => $this->crudPermission ],
					'assign-block' => [ 'permission' => $this->crudPermission ],
					'remove-block' => [ 'permission' => $this->crudPermission ],
					'assign-widget' => [ 'permission' => $this->crudPermission ],
					'remove-widget' => [ 'permission' => $this->crudPermission ],
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'auto-search' => [ 'post' ],
					'update-avatar' => [ 'post' ],
					'update-banner' => [ 'post' ],
					'add-meta' => [ 'post' ],
					'update-meta' => [ 'post' ],
					'delete-meta' => [ 'post' ],
					'assign-element' => [ 'post' ],
					'remove-element' => [ 'post' ],
					'assign-block' => [ 'post' ],
					'remove-block' => [ 'post' ],
					'assign-widget' => [ 'post' ],
					'remove-widget' => [ 'post' ],
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
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
			'update-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateAvatar' ],
			'update-banner' => [ 'class' => 'cmsgears\cms\common\actions\content\UpdateContentBanner' ],
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Create' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Update' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Delete' ],
			'assign-element' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-element' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			'assign-block' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-block' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			'assign-widget' => [ 'class' => 'cmsgears\core\common\actions\object\Assign' ],
			'remove-widget' => [ 'class' => 'cmsgears\core\common\actions\object\Remove' ],
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ArticleController ---------------------

}
