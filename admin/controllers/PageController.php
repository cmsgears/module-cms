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
use cmsgears\cms\admin\models\forms\PageSettingsForm;

use cmsgears\cms\admin\controllers\base\PageController as BasePageController;

/**
 * PageController provides actions specific to page model.
 *
 * @since 1.0.0
 */
class PageController extends BasePageController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Config
		$this->apixBase = 'cms/page';

		$this->settingsClass = PageSettingsForm::class;

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'page' ];

		// Return Url
		$this->returnUrl = Url::previous( 'pages' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/page/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'all' => [ [ 'label' => 'Pages' ] ],
			'create' => [ [ 'label' => 'Pages', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Pages', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Pages', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'settings' => [ [ 'label' => 'Pages', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageController ------------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'pages' );

		return parent::actionAll( $config );
	}

}
