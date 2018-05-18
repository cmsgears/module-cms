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

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\filters\UserExistFilter;

use cmsgears\core\admin\controllers\base\Controller;

class PostController extends Controller {

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
		$this->metaService	= Yii::$app->factory->get( 'contentMetaService' );
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
					'update-avatar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'update-banner' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'assign-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'assign-tags' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-tag' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'add-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'update-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'delete-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
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
					'submit-comment' => [ 'post' ],
					'like' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
			'update-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateAvatar' ],
			'update-banner' => [ 'class' => 'cmsgears\cms\common\actions\content\UpdateContentBanner' ],
			'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\Assign' ],
			'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\Remove' ],
			'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\Assign' ],
			'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\Remove' ],
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Create' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Update' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Delete' ],
			'submit-comment' => [ 'class' => 'cmsgears\core\common\actions\comment\Comment' ],
			'like' => [ 'class' => 'cmsgears\core\common\actions\follower\Like' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

}
