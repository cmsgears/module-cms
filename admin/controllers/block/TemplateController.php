<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\block;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\admin\controllers\base\TemplateController as BaseTemplateController;

/**
 * TemplateController provide actions specific to block templates.
 *
 * @since 1.0.0
 */
class TemplateController extends BaseTemplateController {

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

		// Type
		$this->type		= CmsGlobal::TYPE_BLOCK;
		$this->apixBase	= 'cms/page/template';

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-ui', 'child' => 'block-template' ];

		// Return Url
		$this->returnUrl = Url::previous( 'templates' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/block/template/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Block Templates' ] ],
			'create' => [ [ 'label' => 'Block Templates', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Block Templates', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Block Templates', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TemplateController --------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'templates' );

		return parent::actionAll( $config );
	}

}
