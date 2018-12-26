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
 * TagController provides actions specific to post tags.
 *
 * @since 1.0.0
 */
class TagController extends \cmsgears\cms\admin\controllers\base\TagController {

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
		$this->type			= CmsGlobal::TYPE_POST;
		$this->templateType	= CmsGlobal::TYPE_POST;
		$this->apixBase		= 'cms/page/tag';
		$this->parentPath	= '/cms/post/tag';

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'post-tag' ];

		// Return Url
		$this->returnUrl = Url::previous( 'post-tags' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/tag/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Post Tags' ] ],
			'create' => [ [ 'label' => 'Post Tags', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Post Tags', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Post Tags', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'gallery' => [ [ 'label' => 'Post Tags', 'url' => $this->returnUrl ], [ 'label' => 'Gallery' ] ],
			'data' => [ [ 'label' => 'Post Tags', 'url' => $this->returnUrl ], [ 'label' => 'Data' ] ],
			'config' => [ [ 'label' => 'Post Tags', 'url' => $this->returnUrl ], [ 'label' => 'Config' ] ],
			'settings' => [ [ 'label' => 'Post Tags', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TagController -------------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'post-tags' );

		return parent::actionAll( $config );
	}

}
