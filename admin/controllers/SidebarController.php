<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\admin\controllers\base\ObjectController;

/**
 * SidebarController provides actions specific to sidebar model.
 *
 * @since 1.0.0
 */
class SidebarController extends ObjectController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Config
		$this->type			= CmsGlobal::TYPE_SIDEBAR;
		$this->templateType = CmsGlobal::TYPE_SIDEBAR;
		$this->apixBase		= 'cms/sidebar';

		// Services
		$this->modelService = Yii::$app->factory->get( 'sidebarService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-ui', 'child' => 'usidebar' ];

		// Return Url
		$this->returnUrl = Url::previous( 'sidebars' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/sidebar/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'all' => [ [ 'label' => 'Sidebars' ] ],
			'create' => [ [ 'label' => 'Sidebars', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Sidebars', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Sidebars', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'settings' => [ [ 'label' => 'Sidebars', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ],
			'tdata' => [ [ 'label' => 'Sidebars', 'url' => $this->returnUrl ], [ 'label' => 'Template Data' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SidebarController ---------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'sidebars' );

		return parent::actionAll( $config );
	}

}
