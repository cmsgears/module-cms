<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\post;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * ModelFileController provides actions specific to post files.
 *
 * @since 1.0.0
 */
class ModelFileController extends \cmsgears\core\admin\controllers\base\ModelFileController {

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

		// Config
		$this->title	= 'Post File';
		$this->apixBase	= 'cms/post/model-file';

		// Services
		$this->parentService = Yii::$app->factory->get( 'postService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'post' ];

		// Return Url
		$this->returnUrl = Url::previous( 'post-files' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/file/all' ], true );

		// All Url
		$allUrl = Url::previous( 'posts' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/cms/post/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Posts', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Post Files' ] ],
			'create' => [ [ 'label' => 'Post Files', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Post Files', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Post Files', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ModelFileController -------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'post-files' );

		return parent::actionAll( $pid );
	}

}
