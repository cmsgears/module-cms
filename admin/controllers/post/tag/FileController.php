<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\post\tag;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * FileController provides actions specific to tag files.
 *
 * @since 1.0.0
 */
class FileController extends \cmsgears\core\admin\controllers\base\FileController {

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
		$this->title	= 'Tag File';
		$this->apixBase	= 'cms/tag/file';

		// Services
		$this->parentService = Yii::$app->factory->get( 'tagService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'post-tag' ];

		// Return Url
		$this->returnUrl = Url::previous( 'tag-files' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/tag/file/all' ], true );

		// All Url
		$allUrl = Url::previous( 'post-tags' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/cms/post/tag/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Post Tags', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Files' ] ],
			'create' => [ [ 'label' => 'Files', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Files', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Files', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FileController ------------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'tag-files' );

		return parent::actionAll( $pid );
	}

}
