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
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\admin\controllers\base\GalleryController as BaseGalleryController;

/**
 * GalleryController provide actions specific to tag gallery.
 *
 * @since 1.0.0
 */
class GalleryController extends BaseGalleryController {

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
		$this->type			= CoreGlobal::TYPE_TAG;
		$this->apixBase		= 'cms/page/gallery';
		$this->parentUrl	= '/cms/post/tag/all';
		$this->modelContent	= true;

		// Services
		$this->parentService = Yii::$app->factory->get( 'postService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'post-tag' ];

		// Return Url
		$this->returnUrl = Url::previous( 'tags' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/tag/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [ [ 'label' => 'Tags', 'url' =>  $this->returnUrl ] ],
			'direct' => [ [ 'label' => 'Gallery' ] ],
			'items' => [ [ 'label' => 'Gallery', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ],
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GalleryController ---------------------

}
