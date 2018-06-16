<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\form;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\admin\controllers\base\GalleryController as BaseGalleryController;

/**
 * GalleryController provide actions specific to form gallery.
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
		$this->type			= CoreGlobal::TYPE_FORM;
		$this->apixBase		= 'cms/page/gallery';
		$this->parentUrl	= '/cms/form/all';
		$this->modelContent	= true;

		// Services
		$this->parentService = Yii::$app->factory->get( 'formService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'form' ];

		// Return Url
		$this->returnUrl	= Url::previous( 'forms' );
		$this->returnUrl	= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/form/all/' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [ [ 'label' => 'Forms', 'url' =>  $this->returnUrl ] ],
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
