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
use cmsgears\cms\admin\controllers\base\BlockController as BaseBlockController;

/**
 * BlockController provides actions specific to block model.
 *
 * @since 1.0.0
 */
class BlockController extends BaseBlockController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Config
		$this->apixBase = 'cms/block';

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-ui', 'child' => 'ublock' ];

		// Return Url
		$this->returnUrl = Url::previous( 'blocks' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/block/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'all' => [ [ 'label' => 'Blocks' ] ],
			'create' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'settings' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ],
			'tdata' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Template Data' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BlockController -----------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'blocks' );

		return parent::actionAll( $config );
	}

}
